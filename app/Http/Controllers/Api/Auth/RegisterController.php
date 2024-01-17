<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private User $user;


    /**
     * Handle the incoming request.
     */
    // public function __construct( User $user){

    //     $this->middleware("guest");

    //     $this->model = $user;

    // }



     public function __invoke(RegisterRequest $request)
    {
       //$validated = $request->validated();

    //    $user = User::create($validated);
        // $user =  $this->model->create([
        //     ...$validated,
        //     'password' => bcrypt($request->password),
        // ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;


        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }
}
