<?php

use App\Http\Controllers\Auth\BladeAuthController;
use App\Http\Controllers\Blade\NoteController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware'=>['auth:user']],function(){
    Route::get('/',[HomeController::class,'index'])->name('home');
    Route::get('/logout',[BladeAuthController::class,'logout'])->name('logout');
    // Routes Notes
    Route::get('/notes',[NoteController::class,'index'])->name('note_view');
    Route::get('/note/create',[NoteController::class,'create'])->name('note_create');
    Route::post('/note/store',[NoteController::class,'store'])->name('note_store');
    Route::get('/note/edit/{id}',[NoteController::class,'edit'])->name('note_edit');
    Route::post('/note/update',[NoteController::class,'update'])->name('note_update');
    Route::get('/note/delete/{id}',[NoteController::class,'delete'])->name('note_delete');
});

Route::get('/register/verify/{email}/{remember_token}',[BladeAuthController::class,'verify'])->name('verify_email');
Route::get('/forget-password',[BladeAuthController::class,'forget_password'])->name('forget_password');
Route::post('/forget-password-submit',[BladeAuthController::class,'forget_password_submit'])->name('forget_password_submit');
Route::get('/reset-password/{remember_token}/{email}',[BladeAuthController::class,'reset_password'])->name('reset_password');
Route::post('/reset-password-submit',[BladeAuthController::class,'reset_password_submit'])->name('reset_password_submit');
Route::get('/register',[BladeAuthController::class,'index'])->name('register');
Route::post('/register/store',[BladeAuthController::class,'store'])->name('register_store');
Route::get('/login',[BladeAuthController::class,'login'])->name('login');
Route::post('/login_submit',[BladeAuthController::class,'login_submit'])->name('login_submit');