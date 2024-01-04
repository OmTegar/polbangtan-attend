<?php

namespace App\Http\Controllers;

use App\Models\LoginPermission;
use App\Models\Presence;
use App\Models\prodi;
use App\Models\User;
use App\Models\blokRuangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $date = Carbon::now(); // Mendapatkan tanggal dan waktu saat ini
        $formattedDate = $date->format('j F Y'); // Memformat tanggal sesuai dengan format yang diinginkan

        // Mengambil data semua user
        $user = User::all();

        // Mengambil data semua user yang statusnya adalah diluar
        $userstatus = $user->where('status', 'diluar')->count();

        // Mengambil data presence selama 7 hari terakhir berdasarkan row presence_date, tabel user dan tabel kelas, 
        // jika ada data presence_date yang sama maka akan diambil satu
        $absen7days = Presence::whereDate('presence_date', '>=', now()->subDays(7))
            ->whereDate('presence_date', '<=', now())
            ->with('user')
            ->with('user.kelas')
            ->select('presences.*')
            ->whereIn('id', function ($query) {
                $query->select(User::raw('MAX(id)'))
                    ->from('presences')
                    ->groupBy('presence_date', 'user_id');
            })
            ->orderBy('presence_date', 'desc')
            ->get();

        return view('admin.index', [
            "title" => "Home Admin",
            "absen7days" => $absen7days,
            "userStatus" => $userstatus,
            "userCount" => $user->where('role_id', 3)->count(),
            "ruanganTerisi" => $user->where('role_id', 3)->count(),
            "jumlahPetugas" => User::where('role_id', 1)->orWhere('role_id', 2)->count(),
            "formattedDate" => $formattedDate
        ]);
    }

    public function getDataPresenceUserLast7Days()
    {
        $startDate = now()->subDays(6);
        $endDate = now();

        $data = [
            'data' => []
        ];

        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $formattedDate = $currentDate->format('Y-m-d');
            $totalUser = Presence::whereDate('presence_date', $formattedDate)
                ->whereDate('presence_date', $formattedDate)
                // menfilter agar ngambilnya untuk satu user
                ->whereIn('id', function ($query) {
                    $query->select(User::raw('MAX(id)'))
                        ->from('presences')
                        ->groupBy('presence_date', 'user_id');
                })
                ->orderBy('presence_date', 'desc')
                ->count();

            // Menambahkan total user ke dalam array data
            $data['data'][] = $totalUser;

            $currentDate->addDay();
        }

        return response()->json($data);
    }

    public function dataMahasiswa(Request $request)
    {
        $blokRuangan = blokRuangan::all();
        $kelas = Kelas::all();
        $mahasiswa = User::where('role_id', 3)->paginate(10);

        $title = "Data Mahasiswa";

        return view('admin.data-mahasiswa', compact('mahasiswa', 'blokRuangan', 'kelas', 'title'));
    }

    public function dataMahasiswaEdit($id)
    {
        $user = User::findOrFail($id);
        $blocks = blokRuangan::all();
        $kelas = Kelas::all();
        $title = "Edit Data Mahasiswa";
        $prodiOptions = prodi::all();
        $loginData = LoginPermission::where('user_id', $id)->first();

        if ($loginData == null) {
            $loginStatus = "User Belum Akses Aplikasi";
        } else {
            if ($loginData->is_login == 1) {
                $loginStatus = "User Berhasil Akses Aplikasi";
                if ($loginData->is_login == 0 && $loginData->is_logout == 1) {
                    $loginStatus = "User Keluar aplikasi dengan paksa";
                }
            } else {
                $loginStatus = "User Belum Akses Aplikasi";
            }
        }

        return view('admin.admin-edit.edit-data-mahasiswa', compact('user', 'blocks', 'title', 'loginStatus', 'kelas', 'prodiOptions'));
    }

    public function dataMahasiswaEditData(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'nim' => 'nullable|numeric',
            'no_hp' => 'required|numeric',
            'kelas' => 'required',
            'blok_ruangan_id' => 'required',
            'no_kamar' => 'nullable|numeric',
            'password' => 'nullable|min:8',
            'prodi' => 'required',
            'asal_daerah' => 'required',
        ]);

        $userData = [
            'name' => $request->name ?? $user->name,
            'nim' => $request->nim ?? $user->nim,
            'no_hp' => $request->no_hp ?? $user->no_hp,
            'kelas_id' => $request->kelas ?? $user->kelas_id,
            'blok_ruangan_id' => $request->blok_ruangan_id ?? $user->blok_ruangan_id,
            'no_kamar' => $request->no_kamar ?? $user->no_kamar,
            'prodi_id' => $request->prodi ?? $user->prodi_id,
            'asal_daerah' => $request->asal_daerah ?? $user->asal_daerah,
        ];

        // Perbarui password jika input password tidak kosong
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        dd($userData);
        $user->update($userData);

        return redirect()->route('admin.admin-edit.edit-data-mahasiswa')->with('success', 'Data mahasiswa berhasil diubah.');
    }

    public function dataMahasiswaEditDataResetStatus($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'status' => 'didalam',
        ]);

        return redirect()->route('admin.dataMahasiswa')->with('success', 'Status mahasiswa berhasil direset.');
    }


    public function dataMahasiswaEditDataResetLogin($id, Request $request)
    {
        $user = User::findOrFail($id);

        $desc_logout = isset($request->message) ? $request->message : "Session Expired";

        $user->LoginPermission()->update([
            'is_login' => 0,
            'is_logout' => 0,
            'desc_logout' => $desc_logout,
            'expiry_date' => Carbon::now()->toDateString(),
        ]);

        return redirect()->route('admin.dataMahasiswa')->with('success', 'Status mahasiswa berhasil direset.');
    }



    public function dataMahasiswaDestroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return redirect()->route('admin.dataMahasiswa')->with('success', 'Data mahasiswa berhasil dihapus.');
        }

        return redirect()->route('admin.dataMahasiswa')->with('error', 'Data mahasiswa tidak ditemukan.');
    }

    public function searchMahasiswaByData(Request $request)
    {
        // Mendapatkan nilai blok_ruangan dan nomor_ruangan dari permintaan AJAX
        $blokRuangan = $request->input('blok_ruangan');
        $nomorRuangan = $request->input('nomor_ruangan');

        // Menampilkan data mahasiswa berdasarkan blok_ruangan dan nomor_ruangan
        $mahasiswa = User::where('role_id', 3)
            ->where('blok_ruangan_id', $blokRuangan)
            ->where('no_kamar', $nomorRuangan) // Ubah menjadi 'nomor_ruangan' jika kolom sesuai
            ->with([
                'blok' => function ($query) {
                    $query->select('id', 'name');
                },
                'kelas' => function ($query) {
                    $query->select('id', 'nama_kelas');
                },
            ])
            ->select('id', 'name', 'nim', 'no_kamar', 'blok_ruangan_id', 'no_hp', 'kelas_id')
            ->get();

        // Mengembalikan hasil pencarian dalam format JSON
        return response()->json($mahasiswa);
    }

    public function getNomorRuangan(Request $request)
    {
        $blokRuanganId = $request->input('blok_ruangan');

        // Mencari nomor kamar dari user dengan blok_ruangan_id yang sama dan role_id = 3
        $nomorRuangan = User::where('blok_ruangan_id', $blokRuanganId)
            ->where('role_id', 3)
            ->orderBy('no_kamar', 'asc') // Mengurutkan nomor kamar dari yang terkecil ke terbesar
            ->pluck('no_kamar');

        return response()->json($nomorRuangan);
    }


    public function searchMahasiswaByBlokRuangan(Request $request)
    {
        // Mendapatkan nilai blok_ruangan dari permintaan AJAX
        $blokRuangan = $request->input('blok_ruangan');

        // Menampilkan data mahasiswa berdasarkan blok_ruangan
        $mahasiswa = User::where('role_id', 3)
            ->where('blok_ruangan_id', $blokRuangan)
            ->with([
                'blok' => function ($query) {
                    $query->select('id', 'name');
                },
                'kelas' => function ($query) {
                    $query->select('id', 'nama_kelas');
                }
            ])
            ->select('id', 'name', 'nim', 'no_kamar', 'blok_ruangan_id', 'no_hp', 'kelas_id')
            ->get();

        // dd($mahasiswa);
        // Mengembalikan hasil pencarian dalam format JSON dengan nama blok ruangan
        return response()->json($mahasiswa);
    }

    public function searchMahasiswa(Request $request)
    {
        $search = $request->search_term;

        // Lakukan pencarian di database berdasarkan Nama, No HP, Email, atau NIM
        $results = User::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('nim', 'like', '%' . $search . '%')
            ->orWhere('no_hp', 'like', '%' . $search . '%')
            ->orWhereHas('kelas', function ($query) use ($search) {
                $query->where('nama_kelas', 'like', '%' . $search . '%');
            })
            ->with([
                'blok' => function ($query) {
                    $query->select('id', 'name');
                },
                'kelas' => function ($query) {
                    $query->select('id', 'nama_kelas');
                },
                'Nokelas' => function ($query) {
                    $query->select('id', 'kelas');
                },
                'jenisKelas' => function ($query) {
                    $query->select('id', 'nama_jenis_kelas');
                },
                'levelKelas' => function ($query) {
                    $query->select('id', 'nama_level_kelas');
                },
            ])
            ->select('id', 'name', 'nim', 'no_kamar', 'blok_ruangan_id', 'no_hp', 'kelas_id')
            ->get();

        return response()->json($results);
    }
}