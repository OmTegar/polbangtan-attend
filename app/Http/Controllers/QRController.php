<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Presence;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRController extends Controller
{
    public function index()
    {
        

        return view('admin.presense', );
    }
    // new clean code kodeqr()
    public function kodeqr()
    {
        $user = Auth::user();
        $status = Auth::user()->status;
        if ($status == 'diluar') {
            $editStatus = 'didalam';
        } elseif ($status == 'didalam') {
            $editStatus = 'diluar';
        } else {
            $editStatus = 'telat';
        }

        $validateQR = [
            'user_id' => $user->id,
            'date' => Carbon::now()->format('Y-m-d'),
            'time' => Carbon::now()->format('H:i:s'),
            'status' => $editStatus
        ];

        $title = "Kode QR";

        $json = json_encode($validateQR);
        $QrCode = QrCode::size(400)->eye('circle')->generate($json);
        return view('kodeqr', compact('user', 'QrCode', 'title'));
    }

    // optimalisasi presense()
    public function presense(Request $request)
    {
        $result = $this->validateAttendance($request->date);

        if ($result['success']) {
            $attendance = $result['attendance'];
            $response = $this->processAttendance($request, $attendance);
            return redirect(route('presense'))->with($response['status'], $response['message']);
        } else {
            return redirect(route('presense'))->with('error', $result['message']);
        }
    }

    private function validateAttendance($date)
    {
        $attendance = Attendance::where('date', $date)->first();

        if (!$attendance) {
            // Jika data absensi tidak tersedia, buat data absensi baru
            $attendanceData = [
                'title' => 'Absensi Harian',
                'date' => $date,
                'start_time' => '06:00:00',
                'end_time' => '22:00:00',
            ];
            Attendance::create($attendanceData);

            // Mengembalikan objek absensi yang baru dibuat
            $attendance = Attendance::where('date', $date)->first();

            return ['success' => true, 'attendance' => $attendance];
        }

        $today = Carbon::now()->format('Y-m-d');
        $yesterday = Carbon::now()->subDay()->format('Y-m-d');
        $tomorrow = Carbon::now()->addDay()->format('Y-m-d');

        if ($date == $yesterday || $date == $tomorrow) {
            return ['success' => false, 'message' => 'Tidak diizinkan absensi untuk hari kemarin atau besok.'];
        }

        return ['success' => true, 'attendance' => $attendance];
    }

    private function processAttendance($request, $attendance)
{
    $currentTime = $request->time;
    $status = $request->status;
    $user_id = $request->user_id;
    $date = $request->date;

    if ($currentTime <= $attendance->start_time) {
        return ['status' => 'error', 'message' => 'Absensi belum dibuka.'];
    }

    if ($currentTime >= $attendance->end_time) {
        $presence = $this->findLatestPresence($user_id, $attendance->id, $date);
        if ($status == 'didalam') {
            // Jika pengguna sudah masuk sebelumnya, tandai sebagai telat
            if ($presence && $presence->presence_masuk != null) {
                $is_active = 1;
                $updatedPresence = $this->updatePresence($presence->id, $currentTime, 'telat', $is_active);
                $this->updateUserStatus($user_id, 'telat');
            } else {
                // Jika pengguna belum masuk sebelumnya, tandai sebagai masuk
                $is_active = 1;
                $this->createNewPresence($user_id, $attendance->id, $date, $currentTime, 'didalam');
                $this->updateUserStatus($user_id, 'didalam');
            }
        } elseif ($status == 'telat') {
            return ['status' => 'error', 'message' => 'Anda sudah melakukan absensi namun terlambat.'];
        } elseif ($status == 'diluar') {
            // Jika pengguna ingin keluar, tandai presensi terakhir sebagai keluar
            if ($presence && $presence->presence_keluar == null) {
                $is_active = 1;
                $updatedPresence = $this->updatePresence($presence->id, $currentTime, 'diluar', $is_active);
                $this->updateUserStatus($user_id, 'diluar');
            } else {
                return ['status' => 'error', 'message' => 'Anda belum melakukan absensi masuk hari ini.'];
            }
        }
    } else {
        // Pengguna mencoba masuk sebelum waktu akhir absensi
        // Tandai presensi terakhir sebagai keluar dan buat yang baru sebagai masuk
        $presence = $this->findLatestPresence($user_id, $attendance->id, $date);
        
        if ($presence && $presence->presence_masuk == null) {
            $this->updatePresence($presence->id, $currentTime, 'didalam', 0);
            $this->updateUserStatus($user_id, 'didalam');
        } else {
            // Tandai presensi sebelumnya sebagai tidak aktif dan buat yang baru sebagai masuk
            $is_active = 0;
            if ($presence) {
                $this->updatePresence($presence->id, $currentTime, null , $is_active);
            }
            $this->createNewPresence($user_id, $attendance->id, $date, $currentTime, 'diluar');
            $this->updateUserStatus($user_id, 'diluar');
        }
    }

    return ['status' => 'success', 'message' => 'Absensi berhasil diproses.'];
}


    private function updatePresence($id, $time, $status , $is_active)
    {
        $presenceData = [
            'log_status' => $status,
            'is_active' => $is_active,
        ];

        if ($status == 'didalam') {
            $presenceData['presence_masuk'] = $time;
        } elseif ($status == 'diluar') {
            $presenceData['presence_keluar'] = $time;
        } elseif ($status == 'telat') {
            $presenceData['is_late'] = 1;
            $presenceData['presence_masuk'] = $time;
        } else {
            $presenceData['log_status'] = $status;
        }

        Presence::where('id', $id)->update($presenceData);

        // Mengembalikan objek presensi yang diperbarui
        return Presence::find($id);
    }

    private function updateUserStatus($user_id, $status)
    {
        $user = User::find($user_id);

        if ($user) {
            $user->status = $status;
            $user->save();
        }
    }

    private function findLatestPresence($user_id, $attendance_id, $date)
    {
        return Presence::where('user_id', $user_id)
            ->where('attendance_id', $attendance_id)
            ->where('presence_date', $date)
            ->latest()
            ->first();
    }

    private function createNewPresence($user_id, $attendance_id, $date, $time, $status)
    {
        Presence::create([
            'user_id' => $user_id,
            'attendance_id' => $attendance_id,
            'presence_date' => $date,
            'presence_masuk' => $status == 'didalam' ? $time : null,
            'presence_keluar' => $status == 'diluar' ? $time : null,
            'log_status' => $status,
        ]);
    }
}