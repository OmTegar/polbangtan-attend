<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\prodi;
use App\Models\Kelas;
use App\Models\blokRuangan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role_id == 1 || $user->role_id == 2) {
            return redirect()->route('admin.profil', $user->id);
        }

        if ($user->role_id == 3) {
            return redirect()->route('home.profilshow', $user->id);
        }
    }
    public function profil()
    {
        $user = auth()->user();
        $blocks = BlokRuangan::all();
        $prodis = prodi::all();
        $kelas = kelas::all();

        $title = "Profil";

        return view('profil', compact('user', 'blocks', 'prodis' , 'kelas', 'title'));
    }

    public function editProfile(Request $request, $id)
    {
        // dd($request->all());
        // Validasi data dari formulir
        $request->validate([
            'nim' => 'required|numeric|min:5',
            'name' => 'required|string|max:255',
            'prodi_id' => 'required|string|max:255',
            'kelas_id'=> 'nullable|exists:kelas,id',
            'foto-profil' => 'nullable|image|mimes:jpeg,png,jpg',
            'blok_ruangan_id' => 'nullable|exists:blok_ruangans,id',
            'no_kamar' => 'nullable|numeric',
            'asal_daerah' => 'nullable|string|max:255',
            // Tambahkan aturan validasi lainnya sesuai kebutuhan
        ]);

        // Temukan pengguna berdasarkan ID
        $user = User::find($id);

        // Cek apakah pengguna telah mengunggah file foto baru
        if ($request->hasFile('foto-profil')) {
            // Hapus foto lama
            if ($user->image) {
                Storage::delete('/public/images/' . $user->image);
            }

            // Upload file foto baru ke storage
            $file = $request->file('foto-profil');
            $filename = Str::random(10) . '-' . $file->getClientOriginalName();
            $file->storeAs('images', $filename, 'public');

            // Perbarui URL foto di database
            $user->image = $filename;
        }

        // Periksa apakah pengguna ditemukan
        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }

        // Update data pengguna dengan data yang baru
        $user->nim = $request->nim;
        $user->name = $request->name;
        $user->prodi_id = $request->prodi_id;
        $user->kelas_id = $request->kelas_id;
        $user->blok_ruangan_id = $request->blok_ruangan_id;
        $user->no_kamar = $request->no_kamar;
        $user->asal_daerah = $request->asal_daerah;

        // Simpan perubahan data pengguna
        $user->save();

        if ($user->isAdmin() || $user->isOperator()) {
            return redirect()->route('admin.profil', $user->id)->with('success', 'Profil berhasil diperbarui.');
        } else {
            return redirect()->route('home.profilshow', $user->id)->with('success', 'Profil berhasil diperbarui.');
        }
    }

    public function editProfileGmail(Request $request, $id)
    {
        $request->validate([
            'no_hp' => 'nullable|numeric|digits_between:10,13',
            'email' => [
                'nullable',
                'email:dns',
            ],
            'password' => 'min:5',
        ]);

        $user = User::find($id);

        $user->no_hp = $request->no_hp;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success-email', 'Informasi akun berhasil diperbarui.');
    }
}