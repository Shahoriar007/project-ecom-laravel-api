<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function __construct(){
        $this->middleware("auth:sanctum");
    }
    public function sendMail(){
        \Mail::to(auth()->user())->send(new EmailVerification(auth()->user()));

        return response()->json([
            'message' => 'email verification link send on your email'
        ]);
    }


}
