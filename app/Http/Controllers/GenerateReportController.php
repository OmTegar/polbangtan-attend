<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\blokRuangan;

use Illuminate\Http\Request;
use App\Exports\laporanAbsen;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class GenerateReportController extends Controller
{
    public function index()
    {
        $blok = blokRuangan::all();

        $title = "Generate Report";

        return view('admin.generate', compact('blok', 'title'));
    }

    public function pdfReport(Request $request){
        $request->validate([
            'tanggalSiswa' => 'required',
            'blok' => 'required',
        ]);

        // Mendeklarasi inputan request ke variabel
        $inputWeek = $request->input('tanggalSiswa');
        $blokId = $request->input('blok');

        // jika blokId adalah 1 maka blok adalah A
        if ($blokId == 1) {
            $blok = 'A';
        }elseif ($blokId == 2) {
            $blok = 'B';
        }elseif ($blokId == 3) {
            $blok = 'C';
        }elseif ($blokId == 4) {
            $blok = 'D';
        }elseif ($blokId == 5) {
            $blok = 'E';
        }elseif ($blokId == 6) {
            $blok = 'F';
        }elseif ($blokId == 7) {
            $blok = 'G';
        }elseif ($blokId == 8) {
            $blok = 'H';
        }elseif ($blokId == 9) {
            $blok = 'I';
        }elseif ($blokId == 10) {
            $blok = 'J';
        }elseif ($blokId == 11) {
            $blok = 'B';
        }

        $year = date('Y', strtotime($inputWeek . '-1')); // Tahun dari inputan tanggal
        $weekNumber = date('W', strtotime($inputWeek . '-1')); // Minggu dari inputan tanggal

        $startDate = date("Y-m-d", strtotime("{$year}-W{$weekNumber}-1")); // Hari pertama dalam minggu
        $endDate = date("Y-m-d", strtotime("{$startDate} +6 days"));   // Hari terakhir dalam minggu

        // Mencari data dari tabel presence berdasarkan startDate dan endDate serta berdasarkan user dari blok_ruangan_id yang dipilih
        $data = Presence::whereBetween('presence_date', [$startDate, $endDate])
            ->whereHas('user', function ($query) use ($blokId) {
                $query->where('blok_ruangan_id', $blokId);
            })
            ->with('user')
            ->with('user.kelas')
            ->with('user.blok')
            ->get();

        // Jika value submit sama dengan pdf
         if ($request->submit == 'pdf') {
            $pdf = Pdf::loadView('admin.generate-pdf', compact('data', 'startDate', 'endDate'));
            $storagePath = public_path('pdf');

            // Simpan file pdf
            $pdf->save($storagePath . '/BLOK_'. $blok . '_Laporan-Mingguan-EAbsen-Polbangtan-MLG.pdf');
            // Mengembalikan URL atau path ke file PDF yang baru disimpan
            $pdfFile = asset('pdf/BLOK_'. $blok . '_Laporan-Mingguan-EAbsen-Polbangtan-MLG.pdf');

            // Redirect
            return redirect($pdfFile);
        }

        // Jika value submit sama dengan excel, maka akan mengirim data, startDate, dan endDate tersebut ke exports laporanAbsen
        if ($request->submit == 'excel') {
            Excel::store(new laporanAbsen($data, $startDate, $endDate), 'BLOK_' . $blok . '_Laporan-Mingguan-EAbsen-Polbangtan-MLG.xlsx', 'publicnew', ExcelExcel::XLSX);

            // Mengembalikan URL atau path ke file Excel yang baru disimpan
            $path = asset('excel/BLOK_' . $blok . '_Laporan-Mingguan-EAbsen-Polbangtan-MLG.xlsx');

            // Mengunduh file dari public path
            return redirect($path);
        }
    }
}
