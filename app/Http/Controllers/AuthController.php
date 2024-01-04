<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoginPermission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function authenticate(Request $request)
    {
        // Validasi input email dan password
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        // Temukan pengguna berdasarkan alamat email
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->with('error', 'Login gagal, user tidak ditemukan!');
        }

        // Jika pengguna memiliki role_id 3 (Pengguna Biasa)
        if ($user->role_id == 3) {
            // Cari atau buat entri LoginPermission untuk pengguna ini
            $LoginPermission = LoginPermission::firstOrNew(['user_id' => $user->id]);

            // Jika tidak ada entri LoginPermission yang cocok, buat entri baru dengan status is_login = false
            if (!$LoginPermission->exists) {
                $LoginPermission->is_login = 0;
                $LoginPermission->expiry_date = now()->startOfMonth()->addMonth();
                $LoginPermission->save();
            }

            // Jika pengguna sedang login di perangkat lain, beri pesan kesalahan
            if ($LoginPermission->is_login === 1) {
                if ($LoginPermission->is_logout === 1) {
                    return back()->with('error', 'Login gagal, Anda melakukan logout pada perangkat, silahkan hubungi proktor untuk izin login aplikasi!');
                }
                return back()->with('error', 'Login gagal, Anda sedang login di perangkat lain!');
            }

            // Jika pengguna memiliki izin login, atur status is_login = true dan arahkan ke halaman home atau dashboard
            if ($LoginPermission->is_login === 0) {
                $LoginPermission->is_login = 1;
                $LoginPermission->expiry_date = now()->startOfMonth()->addMonth();
                $LoginPermission->save();

                // Coba otentikasi pengguna
                if (Auth::attempt($credentials, $request->boolean('remember'))) {
                    $user = auth()->user();
                    return redirect()->route('home.index');
                }
            }


        }

        // Jika pengguna memiliki role_id 1 atau 2 (Admin)
        if ($user->role_id == 1 || $user->role_id == 2) {
            // Coba otentikasi pengguna dan arahkan ke halaman admin jika berhasil
            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $user = auth()->user();
                return redirect()->route('admin.index');
            }
        }

        // // Jika otentikasi gagal, kembalikan pesan kesalahan
        return back()->with('error', 'Login gagal, silahkan cek email dan password Anda!');
    }

    public function LogoutAccount()
    {
        $user = auth()->user();

        if ($user->role_id == 3) {
            // Periksa apakah ada entri aktif untuk pengguna ini dalam tabel login_monthlies
            $LoginPermission = LoginPermission::where('user_id', $user->id)
                ->where('is_login', true)
                ->first();

            // Jika ada, atur is_login menjadi true
            if ($LoginPermission) {
                $LoginPermission->is_login = true;
                $LoginPermission->is_logout = true;
                $LoginPermission->desc_logout = 'Siswa melakukan Logout secara paksa dari perangkat pada tanggal ' . now()->format('d-m-Y') . '';
                $LoginPermission->save();
            }

            auth()->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            request()->session()->flush(); // Hapus semua data sesi

            return redirect()->route('auth.login')->with('success', 'Anda berhasil keluar.');

        }
        if ($user->role_id == 1 || $user->role_id == 2) {
            auth()->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            request()->session()->flush(); // Hapus semua data sesi

            return redirect()->route('auth.login')->with('success', 'Anda berhasil keluar.');
        }
    }

    public function authDashboard()
    {
        $user = auth()->user();
        if ($user->role_id==1 || $user->role_id==2) {
            return redirect()->route('admin.index');
        }
        if ($user->role_id==3) {
            return redirect()->route('home.index');
        }
    }
}

