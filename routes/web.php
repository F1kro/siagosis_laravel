<?php

use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\GuruMapelController as AdminGuruMapelController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\NilaiController;
use App\Http\Controllers\Admin\OrtuController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Guru\AbsensiController as GuruAbsensiController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\NilaiController as GuruNilaiController;
use App\Http\Controllers\Orangtua\AnakController;
use App\Http\Controllers\Orangtua\DashboardController as OrangtuaDashboardController;
use App\Http\Controllers\Orangtua\NilaiController as OrangtuaNilaiController;
use App\Http\Controllers\Siswa\BeritaController as SiswaBeritaController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\JadwalController as SiswaJadwalController;
use App\Http\Controllers\Siswa\MapelController as SiswaMapelController;
use App\Http\Controllers\Siswa\NilaiController as SiswaNilaiController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserHasRole;


Route::get('/', function () {
    return view('landing_page');
});

// Redirect berdasarkan role setelah login

// Admin Routes
Route::middleware(['auth', EnsureUserHasRole::class.':admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Guru Management
    Route::resource('guru', GuruController::class)->names([
        'index' => 'guru.index',
        'create' => 'guru.create',
        'store' => 'guru.store',
        'show' => 'guru.show',
        'edit' => 'guru.edit',
        'update' => 'guru.update',
        'destroy' => 'guru.destroy',
    ]);

    // Siswa Management
    Route::resource('siswa', SiswaController::class)->names([
        'index' => 'siswa.index',
        'create' => 'siswa.create',
        'store' => 'siswa.store',
        'show' => 'siswa.show',
        'edit' => 'siswa.edit',
        'update' => 'siswa.update',
        'destroy' => 'siswa.destroy',
    ]);

    // Kelas Management
    Route::resource('kelas', KelasController::class)->names([
        'index' => 'kelas.index',
        'create' => 'kelas.create',
        'store' => 'kelas.store',
        'show' => 'kelas.show',
        'edit' => 'kelas.edit',
        'update' => 'kelas.update',
        'destroy' => 'kelas.destroy',
    ]);;

    // Mapel Management
    Route::resource('mapel', MapelController::class)->names([
        'index' => 'mapel.index',
        'create' => 'mapel.create',
        'store' => 'mapel.store',
        'show' => 'mapel.show',
        'edit' => 'mapel.edit',
        'update' => 'mapel.update',
        'destroy' => 'mapel.destroy',
    ]);;

    // Jadwal Management
    Route::resource('jadwal', JadwalController::class)->names([
        'index' => 'jadwal.index',
        'create' => 'jadwal.create',
        'store' => 'jadwal.store',
        'show' => 'jadwal.show',
        'edit' => 'jadwal.edit',
        'update' => 'jadwal.update',
        'destroy' => 'jadwal.destroy',
    ]);;

    // Nilai Management
    Route::resource('nilai', NilaiController::class)->names([
        'index' => 'nilai.index',
    ])->except(['create', 'store', 'show', 'edit', 'update', 'destroy']);

    // Berita Management
    Route::resource('berita', BeritaController::class)->names([
        'index' => 'berita.index',
        'create' => 'berita.create',
        'store' => 'berita.store',
        'edit' => 'berita.edit',
        'update' => 'berita.update',
        'destroy' => 'berita.destroy',
    ])->except('show');

    // Guru-Mapel Management
    Route::resource('guru-mapel', AdminGuruMapelController::class)->names([
        'index' => 'guru-mapel.index',
        'create' => 'guru-mapel.create',
        'store' => 'guru-mapel.store',
        'show' => 'guru-mapel.show',
        'edit' => 'guru-mapel.edit',
        'update' => 'guru-mapel.update',
        'destroy' => 'guru-mapel.destroy',
    ]);

    Route::resource('absensi', AbsensiController::class)->names([
        'index' => 'absensi.index',
    ])->except(['create', 'store', 'show', 'edit', 'update', 'destroy']);

    Route::resource('ortu', OrtuController::class)->names([
        'index' => 'ortu.index',
        'create' => 'ortu.create',
        'store' => 'ortu.store',
        'show' => 'ortu.show',
        'edit' => 'ortu.edit',
        'update' => 'ortu.update',
        'destroy' => 'ortu.destroy',
    ]);

    Route::resource('users', UsersController::class)->names([
        'index' => 'users.index',
        'create' => 'users.create',
        'store' => 'users.store',
        'show' => 'users.show',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ]);

    Route::patch('berita/{id}/accept', [BeritaController::class, 'accept'])->name('berita.accept');

    Route::get('/berita/{id}', [BeritaController::class, 'showdetail'])->name('berita.showdetail');

    Route::get('nilai/laporan', [NilaiController::class, 'laporan'])->name('nilai.laporan');

    Route::get('absensi/laporan', [AbsensiController::class, 'laporan'])->name('absensi.laporan');

    Route::post('/berita/upload', [BeritaController::class, 'upload'])->name('berita.upload');

});

// Guru Routes
Route::middleware(['auth', EnsureUserHasRole::class.':guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');

    Route::resource('nilai', GuruNilaiController::class)->names([
        'index' => 'nilai.index',
        'create' => 'nilai.create',
        'update' => 'nilai.update',
        'store' => 'nilai.store',
        'edit' => 'nilai.edit',
        'destroy' => 'nilai.destroy',
    ])->except('show');

    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::get('/', [GuruAbsensiController::class, 'dashboard'])->name('dashboard');
        Route::get('/daftar-kehadiran', [GuruAbsensiController::class, 'index'])->name('index');
        Route::get('/input', [GuruAbsensiController::class, 'inputAbsensi'])->name('inputAbsensi');
        Route::post('/', [GuruAbsensiController::class, 'store'])->name('store');
        Route::delete('/hapus-massal', [GuruAbsensiController::class, 'destroy'])->name('destroy');
    });

    Route::get('nilai/dashboard', [GuruNilaiController::class, 'dashboard'])->name('nilai.dashboard');

    Route::get('absensi/dashboard', [GuruAbsensiController::class, 'dashboard'])->name('absensi.dashboard');

    Route::get('absensi/inputAbsensi', [GuruAbsensiController::class, 'inputAbsensi'])->name('absensi.inputAbsensi');


});


// Siswa Routes
Route::middleware(['auth', EnsureUserHasRole::class.':siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

    // Jadwal
    Route::get('jadwal', [SiswaJadwalController::class, 'index'])->name('jadwal.index');

    // Mapel
    Route::get('mapel', [SiswaMapelController::class, 'index'])->name('mapel.index');

    // Nilai
    Route::get('nilai', [SiswaNilaiController::class, 'index'])->name('nilai.index');

    // Berita
    Route::get('berita', [SiswaBeritaController::class, 'index'])->name('berita.index');
    Route::get('berita/{berita}', [SiswaBeritaController::class, 'show'])->name('berita.show');

});

// Orangtua Routes
Route::middleware(['auth', EnsureUserHasRole::class.':orangtua'])->prefix('orangtua')->name('orangtua.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [OrangtuaDashboardController::class, 'index'])->name('dashboard');

    // Anak
    Route::resource('anak', AnakController::class);

    // Nilai
    Route::get('nilai', [OrangtuaNilaiController::class, 'index'])->name('nilai.index');
    Route::get('nilai/{siswa}', [OrangtuaNilaiController::class, 'show'])->name('nilai.show');

    // Absensi
    // Route::get('absensi', [OrangtuaAbsensiController::class, 'index'])->name('absensi.index');
    // Route::get('absensi/{siswa}', [OrangtuaAbsensiController::class, 'show'])->name('absensi.show');

    // Berita
    // Route::get('berita', [OrangtuaBeritaController::class, 'index'])->name('berita.index');
    // Route::get('berita/{berita}', [OrangtuaBeritaController::class, 'show'])->name('berita.show');
});

route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Require auth routes
require __DIR__ . '/auth.php';
