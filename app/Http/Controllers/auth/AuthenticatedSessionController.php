<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class AuthenticatedSessionController extends Controller
{
    public function login(LoginRequest $request): Response
    {
        $request->authenticate();

        $user = User::where('username', $request->username)->first();

        if(!$user) {
            throw ValidationException::withMessages([
                'username' => __('auth.failed'),
            ]);
        }
        $token = $user->createToken("userLoginToken")->plainTextToken;
        $user->save();

        return response(["accessToken" => $token,  "data" => $user], 200);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::user()->tokens()->delete();

        return response()->noContent();
    }
}
