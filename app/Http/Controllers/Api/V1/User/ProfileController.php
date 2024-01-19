<?php

namespace App\Http\Controllers\Api\V1\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Validator;
use Dingo\Api\Exception\UpdateResourceFailedException;

class ProfileController extends Controller
{

    public function generalUpdate(Request $request)
    {

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => ["nullable", "email", Rule::unique('users')->ignore($user->id)],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        if ($validator->fails()) {
            throw new UpdateResourceFailedException('Not Validated', $validator->errors());
        }

        $validated = $validator->validated();

        try {
            DB::transaction(function () use ($user, $validated, $request) {

                if (!empty($validated["name"])) {
                    $user->update([
                        "name" => $validated["name"],
                    ]);
                }

                if (!empty($validated["email"])) {
                    $user->update([
                        "email" => $validated["email"],
                    ]);
                }

                if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                    $user->addMediaFromRequest('avatar')->toMediaCollection('user-avatar');
                }
            });
        } catch (\Throwable $th) {
            throw new UpdateResourceFailedException('Update Failed');
        }

        return $this->response->item($user->fresh(), new UserTransformer());
    }

    public function passwordUpdate(Request $request)
    {

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            throw new UpdateResourceFailedException('Not Validated', $validator->errors());
        }

        $validated = $validator->validated();

        if (!Hash::check($validated['old_password'], $user->password)) {
            throw new UpdateResourceFailedException('Password does not match');
        }

        try {
            if (!empty($validated["password"])) {
                $user->update([
                    "password" => $validated["password"],
                ]);
            }
        } catch (\Throwable $th) {
            throw new UpdateResourceFailedException('Update Failed');
        }

        return $this->response->noContent();
    }
}
