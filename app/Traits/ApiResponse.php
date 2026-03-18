<?php
namespace App\Traits;

trait ApiResponse
{

    protected function success($data, string $message = null, int $code = 200)
    {
        return response()->json([
            'status'  => 'Success',
            'message' => $message,
            'data'    => $data
        ], $code);
    }


    protected function error(string $message = null, int $code, $errors = null)
    {
        return response()->json([
            'status'  => 'Error',
            'message' => $message,
            'errors'  => $errors,
            'data'    => null
        ], $code);
    }
}