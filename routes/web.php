<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ThemeController;

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

// AUTH
Route::get('tutorial', [AuthController::class, 'tutorial'])->name('tutorial');
Route::get('webcam', [AuthController::class, 'webcam'])->name('webcam');

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('login/face', [AuthController::class, 'face'])->name('login.face');
Route::post('post-login', [AuthController::class, 'loginPost'])->name('login.post');
Route::post('post-login-face', [AuthController::class, 'loginPostFace'])->name('login.post.face');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('checkLogin')->group(function ()
{
    // DASHBOARD
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // PROFILE
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('profile/change_profile', [ProfileController::class, 'change_profile'])->name('profile.change_profile');
    Route::post('profile/change_password', [ProfileController::class, 'change_password'])->name('profile.change_password');
    Route::post('profile/face_enroll', [ProfileController::class, 'face_enroll'])->name('profile.face_enroll');
    Route::get('profile/remove_face/{id}', [ProfileController::class, 'remove_face']);

    // USER
    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('user/getById/{id}', [UserController::class, 'getById']);
    Route::post('user/update', [UserController::class, 'update'])->name('user.update');
    Route::get('user/destroy/{id}', [UserController::class, 'destroy']);

    // MODULE MANAGEMENT
    Route::get('module', [ModuleController::class, 'index'])->name('module.index');
    Route::get('module/edit/{id}', [ModuleController::class, 'getById']);
    Route::post('module/update', [ModuleController::class, 'update'])->name('module.update');

    // THEME MANAGEMENT
    Route::get('theme', [ThemeController::class, 'index'])->name('theme.index');
    Route::post('theme/update', [ThemeController::class, 'update'])->name('theme.update');
});
