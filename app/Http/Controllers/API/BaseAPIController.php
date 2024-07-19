<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationFailsException;

class BaseAPIController extends Controller
{
    protected function validateRequest(array $rules, ?array $data = null): array
    {
        $validate = Validator::make($data ?? request()->all(), $rules);

        if ($validate->fails()) {
            throw new ValidationFailsException($validate);
        }

        return $validate->validated();
    }

    protected function responder(string $message, bool $success = true,  array $data = [], MessageBag|array $errors = [], int $httpCode = 200): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data,
            ...$errors,
        ], $httpCode);
    }
}
