<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseAPIController;

class RegisterController extends BaseAPIController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $this->validateRequest([
            'username' => ['required', 'max:255', 'unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8'],
        ]);

        User::create($validated);

        return $this->responder(
            message: 'Successfully registered.',
            httpCode: 201,
        );
    }
}
