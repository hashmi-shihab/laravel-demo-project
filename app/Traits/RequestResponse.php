<?php

namespace App\Traits;

trait RequestResponse
{
    public function successResponse($message, $data = [])
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], 200);
    }

    public function errorResponse($message, $data = [])
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data
        ], 500);
    }

    public function failedResponse($errors)
    {
        return response()->json([
            'status' => false,
            'message' => implode(",", $errors->all())
        ], 422);
    }

    public function customResponse($code, $message, $data = [], $dataName = null)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            $dataName ? "$dataName" : 'data' => $data
        ], $code);
    }
}
