<?php

use App\Http\Controllers\BankSoalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JenjangMapelController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::prefix('dashboard')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        // kelas
        Route::get('kelas', [KelasController::class, 'index'])
            ->name('kelas');
        Route::get('kelas.data', [KelasController::class, 'data'])
            ->name('kelas.data');
        Route::get('kelas.tambah', [KelasController::class, 'tambah'])
            ->name('kelas.tambah');
        Route::post('kelas.simpan', [KelasController::class, 'simpan'])
            ->name('kelas.simpan');
        Route::post('kelas.hapus', [KelasController::class, 'hapus'])
            ->name('kelas.hapus');
        Route::get('kelas/edit/{id}', [KelasController::class, 'edit'])
            ->name('kelas.edit');
        Route::post('kelas.update', [KelasController::class, 'update'])
            ->name('kelas.update');
        Route::post('kelas.hapus', [KelasController::class, 'hapus'])
            ->name('kelas.hapus');

        // guru
        Route::get('guru', [GuruController::class, 'index'])
            ->name('guru');
        Route::get('guru.data', [GuruController::class, 'data'])
            ->name('guru.data');
        Route::get('guru/tambah', [GuruController::class, 'tambah'])
            ->name('guru.tambah');
        Route::post('guru.simpan', [GuruController::class, 'simpan'])
            ->name('guru.sinpan');
        Route::get('guru/edit/{id}', [GuruController::class, 'edit'])
            ->name('guru.edit');
        Route::post('guru.update', [GuruController::class, 'update'])
            ->name('guru.update');
        Route::post('guru.hapus', [GuruController::class, 'hapus'])
            ->name('guru.hapus');

        // mapel
        Route::get('mapel', [MapelController::class, 'index'])
            ->name('mapel');
        Route::get('mapel.data', [MapelController::class, 'data'])
            ->name('mapel.data');
        Route::get('mapel/tambah', [MapelController::class, 'tambah'])
            ->name('mapel.tambah');
        Route::post('mapel.simpan', [MapelController::class, 'simpan'])
            ->name('mapel.simpan');
        Route::get('mapel/edit/{id}', [MapelController::class, 'edit'])
            ->name('mapel.edit');
        Route::get('mapel/detail/{id}', [MapelController::class, 'detail'])
            ->name('mapel.detail');
        Route::post('mapel.hapus', [MapelController::class, 'hapus'])
            ->name('mapel.hapus');

        // jenjang mapel
        Route::get('jenjang_mapel', [JenjangMapelController::class, 'index'])
            ->name('jenjang_mapel');
        Route::get('jenjang_mapel.data', [JenjangMapelController::class, 'data'])
            ->name('jenjang_mapel.data');
        Route::get('jenjang_mapel/tambah', [JenjangMapelController::class, 'tambah'])
            ->name('jenjang_mapel.tambah');
        Route::post('jenjang_mapel.simpan', [JenjangMapelController::class, 'simpan'])
            ->name('jenjang_mapel.simpan');
        Route::get('jenjang_mapel.listKelas', [JenjangMapelController::class, 'listKelas'])
            ->name('jenjang_mapel.listKelas');
        Route::get('jenjang_mapel.listGuru', [JenjangMapelController::class, 'listGuru'])
            ->name('jenjang_mapel.listGuru');
        Route::get('jenjang_mapel.listMapel', [JenjangMapelController::class, 'listMapel'])
            ->name('jenjang_mapel.listMapel');
        Route::post('jenjang_mapel.simpan', [JenjangMapelController::class, 'simpan'])
            ->name('jenjang_mapel.simpan');
        Route::post('jenjang_mapel.hapus', [JenjangMapelController::class, 'hapus'])
            ->name('jenjang_mapel.hapus');



        Route::get('mapel.listKelas', [MapelController::class, 'listKelas'])
            ->name('mapel.listKelas');
        Route::get('mapel.listKelas', [MapelController::class, 'listKelas'])
            ->name('mapel.listKelas');
        Route::get('mapel.listGuru', [MapelController::class, 'listGuru'])
            ->name('mapel.listGuru');

        Route::post('mapel.update', [MapelController::class, 'update'])
            ->name('mapel.update');

        // siswa
        Route::get('siswa', [SiswaController::class, 'index'])
            ->name('siswa');
        Route::get('siswa.data', [SiswaController::class, 'data'])
            ->name('siswa.data');
        Route::get('siswa/tambah', [SiswaController::class, 'tambah'])
            ->name('siswa.tambah');
        Route::post('siswa.simpan', [SiswaController::class, 'simpan'])
            ->name('siswa.simpan');
        Route::get('siswa.listKelas', [SiswaController::class, 'listKelas'])
            ->name('siswa.listKelas');


        // bank soal
        Route::get('bank_soal', [BankSoalController::class, 'index'])
            ->name('bank_soal');
        Route::get('bank_soal.data', [BankSoalController::class, 'data'])
            ->name('bank_soal.data');
        Route::get('bank_soal/tambah', [BankSoalController::class, 'tambah'])
            ->name('bank_soal.tambah');
        Route::get('bank_soal/listGuru/{id_mapel}/{id_kelas}', [BankSoalController::class, 'listGuru'])
            ->name('bank_soal.listGuru');
        Route::get('bank_soal/listKelas/{id}', [BankSoalController::class, 'listKelas'])
            ->name('bank_soal.listKelas');
        Route::get('bank_soal/listMapel', [BankSoalController::class, 'listMapel'])
            ->name('bank_soal.listMapel');
        Route::post('bank_soal.simpan', [BankSoalController::class, 'simpan'])
            ->name('bank_saol.simpan');
        Route::post('bank_soal.hapus', [BankSoalController::class, 'hapus'])
            ->name('bank_soal.hapus');

        // ujian
        Route::get('ujian', [UjianController::class, 'index'])
            ->name('ujian');
        Route::get('ujian.data', [UjianController::class, 'data'])
            ->name('ujian.data');

        // user
        Route::get('user', [UserController::class, 'index'])
            ->name('user');
        Route::get('user.data', [UserController::class, 'data'])
            ->name('user.data');
        Route::get('user/tambah_akun_guru', [UserController::class, 'tambah_akun_guru'])
            ->name('user.tambah_akun_guru');
        Route::post('user.simpan_akun_guru', [UserController::class, 'simpan_akun_guru'])
            ->name('user.simpan_akun_guru');
        Route::post('user.simpan_akun_siswa', [UserController::class, 'simpan_akun_siswa'])
            ->name('user.simpan_akun_siswa');
        Route::get('user.listGuru', [UserController::class, 'listGuru'])
            ->name('user.listGuru');
        Route::get('user/tambah_akun_siswa', [UserController::class, 'tambah_akun_siswa'])
            ->name('user.tambah_akun_siswa');
        Route::get('user.listSiswa', [UserController::class, 'listSiswa'])
            ->name('user.listSiswa');

        // ujian
        Route::get('ujian/{id}', [UjianController::class, 'index'])
            ->name('ujian');
        Route::post('ujian.proses', [UjianController::class, 'proses'])
            ->name('ujian.proses');

        Route::get('hasil_ujian', [UjianController::class, 'hasil_ujian'])
            ->name('hasil_ujian');
        Route::get('hasil_ujian.data', [UjianController::class, 'data_hasil_ujian'])
            ->name('hasil_ujian.data');
    });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
