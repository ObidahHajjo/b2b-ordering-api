<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class Handler
{
    public function render(Request $request, Throwable $exception): JsonResponse
    {
        if ($exception instanceof MissingAttributesException) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }

        // Optional: fallback for other exceptions
        return response()->json([
            'message' => 'Server Error',
        ], 500);
    }
}
