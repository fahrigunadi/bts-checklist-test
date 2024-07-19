<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseAPIController;

class LoginController extends BaseAPIController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $this->validateRequest([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (! Auth::attempt($request->only('username', 'password'))) {
            return $this->responder(
                success: false,
                message: 'Invalid credentials.',
                httpCode: 401,
            );
        }

        $user = User::where('username', $request->username)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->responder(
            message: 'Successfully logged in.',
            data: [
                'access_token' => $token,
                'token_type' => 'Bearer',
            ],
        );
    }
}
