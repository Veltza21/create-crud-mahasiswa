<?php

use App\Http\Controllers\MahasiswaController;
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

Route::get('/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login_post', [App\Http\Controllers\LoginController::class, 'authenticate']);
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout']);

// Route::get('/register', [App\Http\Controllers\registerController::class, 'index'])->middleware('guest');
// Route::post('/register', [App\Http\Controllers\registerController::class, 'store']);
Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index']);
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'welcome']);

    Route::resource('mahasiswa', MahasiswaController::class);
    Route::get('mahasiswa_role_mahasiswa', [App\Http\Controllers\MahasiswaController::class, 'mahasiswa_role_mahasiswa']);
    

    // Route::get('mahasiswa', [App\Http\Controllers\MahasiswaController::class, 'index']);
    // Route::post('mahasiswa/create', [App\Http\Controllers\MahasiswaController::class, 'store']);
    // Route::get('mahasiswa/detail/{id}', [App\Http\Controllers\MahasiswaController::class, 'show']);
    // Route::get('mahasiswa/edit/{id}', [App\Http\Controllers\MahasiswaController::class, 'edit']);
    // Route::post('mahasiswa/update/{id}', [App\Http\Controllers\MahasiswaController::class, 'update']);
    // Route::get('mahasiswa/destroy/{id}', [App\Http\Controllers\MahasiswaController::class, 'destroy']);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('user', [App\Http\Controllers\UserController::class, 'index']);
    Route::post('user/create', [App\Http\Controllers\UserController::class, 'store']);
    Route::get('user/detail/{id}', [App\Http\Controllers\UserController::class, 'show']);
    Route::get('user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit']);
    Route::post('user/update/{id}', [App\Http\Controllers\UserController::class, 'update']);
    Route::get('user/destroy/{id}', [App\Http\Controllers\UserController::class, 'destroy']);


    Route::get('jurusan', [App\Http\Controllers\JurusanController::class, 'index']);
    Route::post('jurusan/create', [App\Http\Controllers\JurusanController::class, 'store']);
    Route::get('jurusan/detail/{id}', [App\Http\Controllers\JurusanController::class, 'show']);
    Route::get('jurusan/edit/{id}', [App\Http\Controllers\JurusanController::class, 'edit']);
    Route::post('jurusan/update/{id}', [App\Http\Controllers\JurusanController::class, 'update']);
    Route::get('jurusan/destroy/{id}', [App\Http\Controllers\JurusanController::class, 'destroy']);

});

// Route::get('/', function () {
//     redirect('/dashboard');
// });

