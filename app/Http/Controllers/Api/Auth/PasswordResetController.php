<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;
use App\Mail\ResetPasswordLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{

    public function __construct(){
        $this->middleware("guest");
    }

    public function sendResetLinkEmail(PasswordResetRequest $request){
        $url = \URL::temporarySignedRoute("password.reset", now()->addMinutes(5), ["email"=> $request->email]);
        $url = str_ireplace(env('APP_URL'), env('FRONTEND_URL'), $url);

        Mail::to($request->email)->send(new ResetPasswordLink($url));

        return response()->json([
            "message"=> "reset password link sent on your email"
        ],200);

    }
}
