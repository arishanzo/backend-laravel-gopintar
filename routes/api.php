<?php

use App\Http\Controllers\Auth\AuthProsesController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\User\UserProfileController;
use App\Models\ProfilUser;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/auth/google/redirect', [GoogleController::class, 'redirectToGoogle']);
Route::post('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::middleware('auth:sanctum')->get('/user', [AuthProsesController::class, 'user']);


Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['csrf' => csrf_token()]);
});


Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return response()->json(['message' => 'Logout berhasil']);
});


Route::post('/daftar', [AuthProsesController::class, 'register']);
Route::post('/login', [AuthProsesController::class, 'login']);

Route::post('/logout', [AuthProsesController::class, 'logout'])->middleware('auth:sanctum');


Route::get('/hello', function () {
    return ['message' => 'Hello from Laravel API 🚀'];
});


Route::middleware(['auth:sanctum','throttle:200,1'])->group(function () {
    Route::post('/profile', [UserProfileController::class, 'store']);
    Route::post('/profileedit/{idprofiluser}', [UserProfileController::class, 'update']);
    Route::get('/profile/{iduser}', [UserProfileController::class, 'getByID']);
});

