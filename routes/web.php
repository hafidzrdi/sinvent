<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangmasukController;
use App\Http\Controllers\BarangkeluarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;

Route::get('/', function () {
    return view('/welcome');
});

Route::resource('kategori',KategoriController::class)->middleware('auth');
Route::resource('barang', BarangController::class)->middleware('auth');
Route::resource('barangmasuk', BarangmasukController::class)->middleware('auth');
Route::resource('barangkeluar', BarangkeluarController::class)->middleware('auth');
// Route::resource('search', BarangController::class)->middleware('auth');

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('register');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('login');
});
 
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
});

// search
Route::get('/search_barang', [SearchController::class, 'search_barang'])->name('search_barang')->middleware('auth');
Route::get('/search_kategori', [SearchController::class, 'search_kategori'])->name('search_kategori')->middleware('auth');