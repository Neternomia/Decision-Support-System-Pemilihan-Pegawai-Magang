<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\HasilAkhirController;
use App\Http\Controllers\LaporanController;
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

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');

Route::resource('periods', PeriodController::class);
Route::patch('periods/{period}/toggle-status', [PeriodController::class, 'toggleStatus'])->name('periods.toggle-status');

Route::resource('kriteria', KriteriaController::class);

Route::resource('alternatif', AlternatifController::class);

Route::resource('kriteria/{kriteriaId}/parameters', ParameterController::class)->except(['show']);
Route::resource('parameter', ParameterController::class);

// Route untuk halaman penilaian
Route::prefix('penilaian')->group(function () {
    Route::get('select', [PenilaianController::class, 'selectAlternatif'])->name('penilaian.select');
    Route::post('store-selected', [PenilaianController::class, 'storeSelectedAlternatif'])->name('penilaian.storeSelected');
    Route::get('form', [PenilaianController::class, 'penilaianForm'])->name('penilaian.form');
    Route::post('store', [PenilaianController::class, 'savePenilaian'])->name('penilaian.store');
});

Route::get('/perhitungan', [PerhitunganController::class, 'index'])->name('perhitungan.index');

Route::get('/hasil-akhir', [HasilAkhirController::class, 'index'])->name('hasil_akhir.index');

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/export', [LaporanController::class, 'exportPdf'])->name('laporan.exportPdf');




