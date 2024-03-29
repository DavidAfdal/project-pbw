<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnggotaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\PeninjauController;
use App\Http\Controllers\ProposalController;
use App\Http\Middleware\Admin;

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

Route::group(['middleware' => 'check.role:dosen'], function () {
    Route::get('/home', [DosenController::class, "home"])->name("home");
    Route::get('/tambah-proposal', [DosenController::class, "tambah"])->name("tambah");
    Route::post('/tambah-proposal', [ProposalController::class, "handleTambahProposal"])->name("proposal.tambah");
    Route::get("/tambah-anggota/{id}", [DosenController::class, "tambahAnggota"])->name("tambahanggota");
    Route::get("/sukses", [DosenController::class, "succes"])->name("succes");
    Route::get("/detail-proposal/{id}", [DosenController::class, "details"])->name("detailProposal");
    Route::post('/tambah-anggota-dosen/{id}',[AnggotaController::class, "TambahAnggotaDosen"])->name("tambah.anggotaDosen");
    Route::post('/tambah-anggota-mahasiswa/{id}',[AnggotaController::class, "TambahAnggotaMahasiswa"])->name("tambah.anggotaMahasiswa");
    Route::post('/tambah-mitra/{id}', [AnggotaController::class, "TambahMitra"])->name("tambah.mitra");
});

Route::group(['middleware' => 'check.role:peninjau'], function () {
   Route::get("/peninjau/daftar-tinjauan", [PeninjauController::class, "index" ])->name("daftarTinjauan");
   Route::get("/peninjau/detail-proposal/{id}", [PeninjauController::class, "details" ])->name("daftarTinjauan");
   Route::post('/peninjau/tambah-comment/{id}',  [PeninjauController::class, "TambahComment" ])->name("tambah.comment");
});

Route::group(['middleware' => 'check.role:admin'], function () {
   Route::get("/admin/dashboard", [AdminController::class, "index" ])->name("dashboard");
   Route::get("/admin/detail-proposal/{id}", [AdminController::class, "details" ])->name("detailsAdmin");
   Route::post('/search-peninjau', [AdminController::class, 'searchPeninjau'])->name('searchPeninjau');
   Route::post('/tambah-peninjau/{id}', [AdminController::class, 'tambahPeninjau'])->name('tambahPeninjau');
   Route::get("/proposal-year", [AdminController::class, "getProposalByYear" ])->name("getProposalByYear");
});

Route::group(['middleware' => 'check.login'], function() {
    Route::get("/register", [AuthController::class, "register"])->name("register");
    Route::post("/handle-register", [AuthController::class, "handleRegister"])->name("auth.post.register");
    Route::get("/login", [AuthController::class, "login"])->name("login");
    Route::post("/login", [AuthController::class, "handleLogin"])->name("auth.post.login");
    Route::get("/", [AuthController::class, "tentangKami"])->name("tentang-kami");
});


Route::get('/download/{filename}', [ProposalController::class, "download"])->name('download');
Route::get('/download-panduan/{filename}', [AuthController::class, "downloadPanduan"])->name('downloadPanduan');
Route::get("/logout", [AuthController::class, "logout"])->name("auth.logout");
