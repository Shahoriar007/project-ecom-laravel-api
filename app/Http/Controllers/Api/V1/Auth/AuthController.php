<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Validator;
use Dingo\Api\Exception\ResourceException;
use App\Http\Resources\V1\User\UserResource;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AuthController extends Controller
{

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => ["required", "email"],
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ResourceException('Not Validated', $validator->errors());
        }

        $validated = $validator->validated();


        $user = User::where(['email' => $validated['email']])->first();


        if (!$user->status) {
            throw new AccessDeniedHttpException('You must be active to login.');
        }

        if ($token = $this->guard()->attempt($validator->validated())) {
            return $this->respondWithToken($token);
        }

        return response()->json([
            "errors" => [
                'email' => 'The provided credentials are incorrect.'
            ]
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        try {
            return $this->response->item($this->guard()->user(), new UserTransformer());
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL()
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
