<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\PasswordResetController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::post('login',LoginController::class);
Route::post('logout',LogoutController::class);
Route::post('register',RegisterController::class);
Route::post('email/verify/send',[VerifyEmailController::class, 'sendMail']);
Route::post('password/reset/email',[PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('password/reset',[PasswordResetController::class, 'reset'])->name('password.reset');



?>

