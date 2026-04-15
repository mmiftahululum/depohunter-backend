<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Return a standardized success response
     *
     * @param mixed $result The result data to return
     * @param string $message Optional success message
     * @param int $httpCode HTTP status code (default: 200)
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($result = null, string $message = '', int $httpCode = 200)
    {
        return response()->json([
            'codestatus' => 'S',
            'message' => $message,
            'result' => $result
        ], $httpCode);
    }

    /**
     * Return a standardized error response
     *
     * @param string $message Error message
     * @param mixed $result Optional error details
     * @param int $httpCode HTTP status code (default: 400)
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse(string $message, $result = null, int $httpCode = 400)
    {
        return response()->json([
            'codestatus' => 'E',
            'message' => $message,
            'result' => $result
        ], $httpCode);
    }
}
