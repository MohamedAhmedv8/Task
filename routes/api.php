<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Api\UserProfileController;

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
Route::post('/register',[ApiAuthController::class,'register']);
Route::post('/login',[ApiAuthController::class,'login']);
Route::middleware('is_user')->group(function(){
    Route::post('/logout',[ApiAuthController::class,'logout']);
    Route::get('/profile',[UserProfileController::class,'show']);
    Route::post('/update/profile',[UserProfileController::class,'update']);
    Route::post('/note/store',[NoteController::class,'store']);
    Route::get('/note/show',[NoteController::class,'show']);
    Route::post('/note/update/{id}',[NoteController::class,'update']);
    Route::get('/note/delete/{id}',[NoteController::class,'delete']);
});