<?php

namespace App\Traits;

trait ApiResponses
{
    public function successResponse($message = "", $data = [], $code = 200)
    {
        return response()->json([
            'message' => $message,
            'code' => $code,
            'success' => true,
            'data' => $data,
        ]);
    }
    public function errorResponse($message, $code)
    {
        return response()->json([
            'error' => $message,
            'code' => $code,
            'success' => false,
        ]);
    }
}
