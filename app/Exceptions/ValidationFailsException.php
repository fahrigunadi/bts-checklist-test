<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;

class ValidationFailsException extends Exception
{
    public function __construct(
        protected Validator $validator,
    ) {}

    /**
     * Render the exception into an HTTP RedirectResponse.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->validator->errors()->first(),
            'errors' => $this->validator->errors(),
            'data' => [],
        ], 422);
    }
}
