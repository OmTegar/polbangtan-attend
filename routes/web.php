<?php

use App\Http\Controllers\AbsensiMahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QRController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\GenerateReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// INI ROUTE UNTUK DEVELOPMENT BACKEND
Route::get('/presense', [QRController::class, 'index'])->name('presense');

// INI KHUSUS DATA API
Route::post('/presense/api', [QRController::class, 'presense'])->name('presense.api');
Route::get('/getDataPresenceUserLast7Days', [DashboardController::class, 'getDataPresenceUserLast7Days'])->name('getDataPresenceUserLast7Days');
Route::get('/get-presence-date', [HomeController::class, 'getPresenceDate'])->name('home.get-presence-date');


Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect('/login');
    });
    // LOGIN ROUTE
    Route::get('/login', [AuthController::class, 'index'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [AuthController::class, 'authDashboard'])->name('auth.dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('rumah');
    Route::get('/profil', [ProfileController::class, 'index'])->name('user.profil');

    Route::middleware('role:user')->name('home.')->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('index');
        Route::get('/dashboard/profil', [ProfileController::class, 'profil'])->name('profilshow');
        Route::post('/dashboard/profil/{id}', [ProfileController::class, 'editProfile'])->name('Editprofil');
        Route::post('/dashboard/profil-gmail/{id}', [ProfileController::class, 'editProfileGmail'])->name('EditprofilGmail');
        Route::get('/dashboard/kode-qr', [QRController::class, 'kodeqr'])->name('kodeqr');
        Route::get('/dashboard/riwayat-absen', [HomeController::class, 'riwayat'])->name('riwayatindex');
    });

    Route::middleware('role:admin,operator')->name('admin.')->group(function () {
        Route::get('/dashboard-admin', [DashboardController::class, 'index'])->name('index');

        Route::get('/profil-admin', [ProfileController::class, 'profil'])->name('profil');
        Route::post('/profil-admin/{id}', [ProfileController::class, 'editProfile'])->name('editProfile');
        Route::post('/profil-admin-gmail/{id}', [ProfileController::class, 'editProfileGmail'])->name('editProfileGmail');

        Route::get('/data-mahasiswa', [DashboardController::class, 'dataMahasiswa'])->name('dataMahasiswa');
        Route::post('/data-mahasiswa/get-nomor-ruangan', [DashboardController::class, 'getNomorRuangan'])->name('getNomorRuangan');
        Route::post('/data-mahasiswa/search-blokruangan', [DashboardController::class, 'searchMahasiswaByBlokRuangan'])->name('searchMahasiswaByBlokRuangan');
        Route::post('/data-mahasiswa/search-mahasiswa-by-data', [DashboardController::class, 'searchMahasiswaByData'])->name('searchMahasiswaByData');
        Route::post('/data-mahasiswa/searchbar-mahasiswa', [DashboardController::class, 'searchMahasiswa'])->name('searchMahasiswa');
        Route::get('/data-mahasiswa/edit/{id}', [DashboardController::class, 'dataMahasiswaEdit'])->name('dataMahasiswaEdit');
        Route::post('/data-mahasiswa/edit/{id}', [DashboardController::class, 'dataMahasiswaEditData'])->name('dataMahasiswaEditData');
        Route::post('/data-mahasiswa/edit/resetstatus/{id}', [DashboardController::class, 'dataMahasiswaEditDataResetStatus'])->name('dataMahasiswaEditDataResetStatus');
        Route::post('/data-mahasiswa/edit/resetlogin/{id}', [DashboardController::class, 'dataMahasiswaEditDataResetLogin'])->name('dataMahasiswaEditDataResetLogin');
        Route::delete('/data-mahasiswa/{id}', [DashboardController::class, 'dataMahasiswaDestroy'])->name('dataMahasiswaDestroy');

        Route::get('/absensi-mahasiswa', [AbsensiMahasiswa::class, 'index'])->name('absensiMahasiswa');
        Route::get('/absensi-mahasiswa/getNomorRuangan', [AbsensiMahasiswa::class, 'getNomorRuangan'])->name('absensiMahasiswaGetNomorRuangan');
        Route::get('/absensi-mahasiswa/getDataAbsen', [AbsensiMahasiswa::class, 'getDataAbsen'])->name('absensiMahasiswaGetDataAbsen');


        Route::get('/data-petugas', [DashboardAdminController::class, 'showDataPetugas'])->name('dataPetugas');
        Route::get('/data-petugas/create-show', [DashboardAdminController::class, 'createDataPetugasShow'])->name('createPetugasShow');
        Route::post('/data-petugas/create', [DashboardAdminController::class, 'createDataPetugas'])->name('createPetugas');
        Route::get('/data-petugas/{id}', [DashboardAdminController::class, 'editDataPetugasShow'])->name('editDataPetugasShow');
        Route::post('/data-petugas/edit/{id}', [DashboardAdminController::class, 'editDataPetugas'])->name('editDataPetugas');
        Route::delete('/data-petugas/destroy/{id}', [DashboardAdminController::class, 'destroyDataPetugas'])->name('destroyPetugas');

        Route::get('/piket-petugas/generate-jadwal-mingguan', [DashboardAdminController::class, 'piketPetugasGenerateJadwalMingguan'])->name('piketPetugasGenerateJadwalMingguan');
        Route::post('/piket-petugas/generate-jadwal', [DashboardAdminController::class, 'piketPetugasGenerateJadwal'])->name('piketPetugasGenerateJadwal');

        Route::get('/piket-petugas', [DashboardAdminController::class, 'showPiketPetugas'])->name('piketPetugas');
        Route::get('/piket-petugas/edit/{id}', [DashboardAdminController::class, 'showPiketPetugasSingle'])->name('showPiketPetugasSingle');
        Route::post('/piket-petugas/update/{id}', [DashboardAdminController::class, 'updatePiketPetugas'])->name('updatePiketPetugas');
        // Route::delete('/piket-petugas/delete/{id}', [DashboardAdminController::class, 'deletePiketPetugasSingle'])->name('deletePiketPetugasSingle');

        Route::get('/kamera-scan', [DashboardAdminController::class, 'showKamera'])->name('kamera');

        Route::get('/generate-laporan', [GenerateReportController::class, 'index'])->name('generate');
        Route::post('/generate-laporan', [GenerateReportController::class, 'pdfReport'])->name('generatepPdf');

        Route::get('sistem-admin', [DashboardAdminController::class, 'showSistemAdmin'])->name('sistem-admin');
        Route::post('sistem-admin/importclass', [DashboardAdminController::class, 'importClassSistemAdmin'])->name('sistemAdminImportClass');
        Route::post('sistem-admin/upgradeclass', [DashboardAdminController::class, 'upgradeClassSistemAdmin'])->name('sistemAdminUpgradeClass');
    });

    // LOGOUT ROUTE
    Route::delete('/logout', [AuthController::class, 'LogoutAccount'])->name('auth.logout');
});

require __DIR__.'/api.php';
