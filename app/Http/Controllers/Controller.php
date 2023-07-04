<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Return success response.
     *
     * @param string $message
     * @param array $data
     * @param integer $code
     * @return void
     */
    public function success(string $message, array $data = [], int $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Return error response.
     * 
     * @param string $message
     * @param array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function error(string $message, array $data = [], int $code = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
