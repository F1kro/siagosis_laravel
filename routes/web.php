<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\NilaiController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\OrtuController;
// use App\Http\Controllers\Admin\;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\JadwalController as GuruJadwalController;
use App\Http\Controllers\Guru\KelasController as GuruKelasController;
use App\Http\Controllers\Guru\MapelController as GuruMapelController;
use App\Http\Controllers\Guru\NilaiController as GuruNilaiController;
use App\Http\Controllers\Guru\AbsensiController as GuruAbsensiController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\JadwalController as SiswaJadwalController;
use App\Http\Controllers\Siswa\MapelController as SiswaMapelController;
use App\Http\Controllers\Siswa\NilaiController as SiswaNilaiController;
use App\Http\Controllers\Siswa\BeritaController as SiswaBeritaController;
use App\Http\Controllers\Orangtua\DashboardController as OrangtuaDashboardController;
use App\Http\Controllers\Orangtua\AnakController;
use App\Http\Controllers\Orangtua\NilaiController as OrangtuaNilaiController;
use App\Http\Controllers\Orangtua\AbsensiController as OrangtuaAbsensiController;
use App\Http\Controllers\Orangtua\BeritaController as OrangtuaBeritaController;
use App\Http\Controllers\Admin\UsersController; // Ensure this class exists in the specified namespace
use Illuminate\Container\Attributes\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

// Auth routes (menggunakan Laravel Breeze/Fortify)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Redirect berdasarkan role setelah login


// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
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
        'create' => 'nilai.create',
        'store' => 'nilai.store',
        'show' => 'nilai.show',
        'edit' => 'nilai.edit',
        'update' => 'nilai.update',
        'destroy' => 'nilai.destroy',
    ]);;

    // Absensi Management
    Route::resource('absensi', AbsensiController::class)->names([
        'index' => 'absensi.index',
        'create' => 'absensi.create',
        'store' => 'absensi.store',
        'show' => 'absensi.show',
        'edit' => 'absensi.edit',
        'update' => 'absensi.update',
        'destroy' => 'absensi.destroy',
    ]);;

    // Berita Management
    Route::resource('berita', BeritaController::class)->names([
        'index' => 'berita.index',
        'create' => 'berita.create',
        'store' => 'berita.store',
        'show' => 'berita.show',
        'edit' => 'berita.edit',
        'update' => 'berita.update',
        'destroy' => 'berita.destroy',
    ]);;

    // Guru-Mapel Management
    Route::resource('guru-mapel', GuruMapelController::class)->names([
        'index' => 'guru-mapel.index',
        'create' => 'guru-mapel.create',
        'store' => 'guru-mapel.store',
        'show' => 'guru-mapel.show',
        'edit' => 'guru-mapel.edit',
        'update' => 'guru-mapel.update',
        'destroy' => 'guru-mapel.destroy',
    ]);

    // Nilai Management
    Route::resource('nilai', NilaiController::class)->names([
        'index' => 'nilai.index',
        'create' => 'nilai.create',
        'store' => 'nilai.store',
        'show' => 'nilai.show',
        'edit' => 'nilai.edit',
        'update' => 'nilai.update',
        'destroy' => 'nilai.destroy',
    ]);

    // Absensi Management
    Route::resource('absensi', AbsensiController::class)->names([
        'index' => 'absensi.index',
        'create' => 'absensi.create',
        'store' => 'absensi.store',
        'show' => 'absensi.show',
        'edit' => 'absensi.edit',
        'update' => 'absensi.update',
        'destroy' => 'absensi.destroy',
    ]);

    Route::resource('ortu', OrtuController::class)->names([
        'index' => 'ortu.index',
        'create' => 'ortu.create',
        'store' => 'ortu.store',
        'show' => 'ortu.show',
        'edit' => 'ortu.edit',
        'update' => 'ortu.update',
        'destroy' => 'ortu.destroy',
    ]);

});


// Guru Routes
Route::middleware(['auth'])->prefix('guru')->name('guru.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');

    // Jadwal
    // Route::resource('jadwal', GuruJadwalController::class);

    // // Kelas
    // Route::resource('kelas', GuruKelasController::class);

    // Mapel
    Route::resource('mapel', GuruMapelController::class);

    // Nilai
    Route::resource('nilai', GuruNilaiController::class);

    // Absensi
    Route::resource('absensi', GuruAbsensiController::class);

    // Berita
    // Route::get('berita', [GuruBeritaController::class, 'index'])->name('berita.index');
    // Route::get('berita/{berita}', [GuruBeritaController::class, 'show'])->name('berita.show');

});

// Siswa Routes
Route::middleware(['auth'])->prefix('siswa')->name('siswa.')->group(function () {
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
Route::middleware(['auth'])->prefix('orangtua')->name('orangtua.')->group(function () {
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
require __DIR__.'/auth.php';
