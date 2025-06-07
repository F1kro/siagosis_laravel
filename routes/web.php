<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserHasRole;

//  Controller Umum
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\OrtuController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\JadwalController as AdminJadwalController;
use App\Http\Controllers\Admin\GuruMapelController as AdminGuruMapelController;
use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController;
use App\Http\Controllers\Admin\NilaiController as AdminNilaiController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\RankingController as AdminRankingController;

// Guru Controllers
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\AbsensiController as GuruAbsensiController;
use App\Http\Controllers\Guru\NilaiController as GuruNilaiController;
use App\Http\Controllers\Guru\JadwalController as GuruJadwalController;
use App\Http\Controllers\Guru\BeritaController as GuruBeritaController;
use App\Http\Controllers\Guru\RankingController as GuruRankingController;

// Siswa Controllers
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\AbsensiController as SiswaAbsensiController;
use App\Http\Controllers\Siswa\NilaiController as SiswaNilaiController;
use App\Http\Controllers\Siswa\JadwalController as SiswaJadwalController;
use App\Http\Controllers\Siswa\BeritaController as SiswaBeritaController;
use App\Http\Controllers\Siswa\TodoListController;

// Orangtua Controllers
use App\Http\Controllers\Orangtua\DashboardController as OrangtuaDashboardController;
use App\Http\Controllers\Orangtua\AbsensiController as OrangtuaAbsensiController;
use App\Http\Controllers\Orangtua\NilaiController as OrangtuaNilaiController;
use App\Http\Controllers\Orangtua\BeritaController as OrangtuaBeritaController;
use App\Http\Controllers\Orangtua\RankingController as OrangtuaRankingController;


// Landing Page
Route::get('/', function () {
    return view('landing_page');
});

// ADMIN ROUTES
Route::middleware(['auth', EnsureUserHasRole::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Resource Management
    Route::resource('guru', GuruController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('mapel', MapelController::class);
    Route::resource('jadwal', AdminJadwalController::class);
    Route::resource('guru-mapel', AdminGuruMapelController::class);
    Route::resource('ortu', OrtuController::class);
    Route::resource('users', UsersController::class);

    // Berita Management
    Route::resource('berita', AdminBeritaController::class)->except('show');
    Route::get('/berita/{id}', [AdminBeritaController::class, 'showdetail'])->name('berita.showdetail');
    Route::patch('berita/{id}/accept', [AdminBeritaController::class, 'accept'])->name('berita.accept');
    Route::post('/berita/upload', [AdminBeritaController::class, 'upload'])->name('berita.upload');

    // Absensi & Nilai (View Only) & Laporan
    Route::get('absensi', [AdminAbsensiController::class, 'index'])->name('absensi.index');
    Route::get('absensi/laporan', [AdminAbsensiController::class, 'laporan'])->name('absensi.laporan');
    Route::get('nilai', [AdminNilaiController::class, 'index'])->name('nilai.index');
    Route::get('nilai/laporan', [AdminNilaiController::class, 'laporan'])->name('nilai.laporan');

    // Ranking Management
    Route::get('/ranking', [AdminRankingController::class, 'index'])->name('ranking.index');
    Route::post('/ranking', [AdminRankingController::class, 'store'])->name('ranking.store');
    Route::delete('/ranking', [AdminRankingController::class, 'destroy'])->name('ranking.destroy');
});

// GURU ROUTES
Route::middleware(['auth', EnsureUserHasRole::class . ':guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');
    Route::get('/jadwal/semua', [GuruJadwalController::class, 'daftarSemuaJadwal'])->name('jadwal.semua');
    Route::get('/ranking', [GuruRankingController::class, 'index'])->name('ranking.index');

    // Absensi
    Route::get('/absensi', [GuruAbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/input', [GuruAbsensiController::class, 'inputAbsensi'])->name('absensi.input');
    Route::post('/absensi', [GuruAbsensiController::class, 'store'])->name('absensi.store');
    Route::delete('/absensi/hapus-massal', [GuruAbsensiController::class, 'destroy'])->name('absensi.destroy');

    // Nilai
    Route::get('/nilai/dashboard', [GuruNilaiController::class, 'dashboard'])->name('nilai.dashboard');
    Route::resource('nilai', GuruNilaiController::class)->except('show');

    // Berita
    Route::resource('berita', GuruBeritaController::class)->only(['index', 'show']);
});


// SISWA ROUTES
Route::middleware(['auth', EnsureUserHasRole::class . ':siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/jadwal', [SiswaJadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/nilai', [SiswaNilaiController::class, 'index'])->name('nilai.index');
    Route::get('/absensi', [SiswaAbsensiController::class, 'index'])->name('absensi.index');

    // Berita
    Route::resource('berita', SiswaBeritaController::class)->only(['index', 'show']);

    // To-Do List
    Route::resource('todolist', TodoListController::class)->except('show');
});


// ORANG TUA ROUTES
Route::middleware(['auth', EnsureUserHasRole::class . ':orangtua'])->prefix('orangtua')->name('orangtua.')->group(function () {
    Route::get('/dashboard', [OrangtuaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/nilai', [OrangtuaNilaiController::class, 'index'])->name('nilai.index');
    Route::get('/absensi', [OrangtuaAbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/ranking', [OrangtuaRankingController::class, 'index'])->name('ranking.index');

    // Berita
    Route::resource('berita', OrangtuaBeritaController::class)->only(['index', 'show']);
});


// AUTHENTICATED USER ROUTES (PROFILE, LOGOUT)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::patch('/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::patch('/profile/update-password', [UserController::class, 'updatePassword'])->name('user.profile.update-password');
    Route::post('/profile/update-photo', [UserController::class, 'updatePhoto'])->name('user.profile.update-photo');
});

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

require __DIR__.'/auth.php';