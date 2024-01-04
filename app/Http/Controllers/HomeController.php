<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\User;
use App\Models\Presence;
use App\Models\LoginPermission;

use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JadwalPetugas;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\Crypt;
use Nette\Utils\Json;

class HomeController extends Controller
{
    public function index()
    {
        $user = User::all();
        // mengambil status pada berdasarkan auth user
        $status = Auth::user();

        $title = "Home";

        // Total user
        $totaluser = $user->count();
        $activeuser = LoginPermission::where('is_login', 1)->count();

        $rekap = Presence::where('user_id', $status->id)
            ->whereDate('presence_date', '>=', now()->subDays(7))
            ->whereDate('presence_date', '<=', now())
            ->distinct('presence_date');
        $total_days = $rekap->count();

        $jadwalPiket = JadwalPetugas::where('date', now()->format('y-m-d'))->first();
        if ($jadwalPiket != null) {
            $petugas1 = User::where('id', $jadwalPiket->petugas1_id)->value('name');
            $petugas2 = User::where('id', $jadwalPiket->petugas2_id)->value('name');
            if ($jadwalPiket->petugas1_id == null) {
                $petugas1 = "Belum ada";
                if ($jadwalPiket->petugas2_id == null) {
                    $petugas2 = "Belum ada";
                }   
            }
        } else {
            $petugas1 = "Belum ada";
            $petugas2 = "Belum ada";
        }

        return view('index', compact('totaluser', 'activeuser', 'status', 'total_days', 'title', 'petugas1', 'petugas2'));
    }

    public function riwayat(Request $request)
    {
        $filter = $request->input('filter', 'all');
        $query = Presence::where('user_id', Auth::user()->id);

        if (!$filter) {
            $filter = 'all';
        }

        $query = Presence::where('user_id', Auth::user()->id);

        switch ($filter) {
            case '7-days':
                $query->whereBetween('presence_date', [now()->subDays(7), now()]);
                break;
            case '14-days':
                $query->whereBetween('presence_date', [now()->subDays(14), now()]);
                break;
            case '30-days':
                $query->whereBetween('presence_date', [now()->subDays(30), now()]);
                break;
            case '6-month':
                $query->whereBetween('presence_date', [now()->subMonths(6), now()]);
                break;
            default:
                break;
        }

        $title = "Riwayat Absen";

        $riwayat = $query->orderBy('presence_date', 'desc')
            ->distinct('presence_date')->get();
        return view('riwayat', compact('riwayat', 'filter', 'title'));
    }

    public function getPresenceDate()
    {
        $user = auth()->user();

        $presenceDates = Presence::where('user_id', $user->id)->select('presence_date')->distinct()->get();

        return response()->json($presenceDates);
    }



    // $user_id = Auth::user()->id;
    // ambil data terakhir dari tabel attendances dan simpan sebagai variabel $attendance_id
    // create tabel baru di database dengan nama token_absens dengan data berikut id	user_id	attendance_id	token	expired_at	created_at	updated_at	
    // $getAbsen = tokenAbsen::where('user_id', $token)->first();
    // dd($token);
}