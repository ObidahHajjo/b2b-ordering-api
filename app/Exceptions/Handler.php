<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class Handler
{
    /**
     * Render an API exception response.
     *
     * @param  Request  $request  Incoming request.
     * @param  Throwable  $exception  Thrown exception.
     * @return JsonResponse Exception response.
     */
    public function render(Request $request, Throwable $exception): JsonResponse
    {
        if ($exception instanceof MissingAttributesException) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }

        return response()->json([
            'message' => 'Server Error',
        ], 500);
    }
}
