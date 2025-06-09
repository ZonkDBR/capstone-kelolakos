<?php

use App\Models\Transaksi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\ProfileController;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LokasiKosController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\SwitchLocationController;
use App\Http\Controllers\User\PembayaranController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\TagihanController;

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
//route login
Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'process']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/', function () {
    return redirect('/dashboard');
})->middleware('auth');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/lokasi', LokasiKosController::class);
    Route::resource('/kamar', KamarController::class);
    Route::resource('/penghuni', PenghuniController::class);
    Route::resource('/sewa', SewaController::class);

    //Route Transaksi
    Route::get('/transaksi/laporan', [TransaksiController::class, 'laporan'])->name('transaksi.laporan');
    Route::get('/transaksi/pemasukan', [TransaksiController::class, 'pemasukan'])->name('transaksi.pemasukan');
    Route::get('/transaksi/pengeluaran', [TransaksiController::class, 'pengeluaran'])->name('transaksi.pengeluaran');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/export-excel', [TransaksiController::class, 'exportExcel'])->name('transaksi.exportExcel');
    Route::get('/transaksi/export-pdf', [TransaksiController::class, 'exportPdf'])->name('transaksi.exportPdf');
    Route::get('/transaksi/{id}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
    Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');

    // Routes for tagihan
    Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
    Route::get('/tagihan/create/{id_sewa}', [TagihanController::class, 'create'])->name('tagihan.create');
    Route::post('/tagihan', [TagihanController::class, 'store'])->name('tagihan.store');


    Route::post('/switch-location', [SwitchLocationController::class, 'switchLocation'])
        ->name('switch.location')
    ;
    Route::singleton('/profile', ProfileController::class)
        ->names([
            'show'   => 'admin-profile.show',
            'edit'   => 'admin-profile.edit',
            'update' => 'admin-profile.update',
        ]);
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/user/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');

    // Profile route with singleton resource
    Route::singleton('/user/profile', UserProfileController::class);
});
