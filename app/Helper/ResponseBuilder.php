<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class ResponseBuilder
{
    public static function success($data = null): JsonResponse
    {
        return Response::json([
            'success' => true,
            'data' => $data
        ])
            ->setCharset('utf-8')
            ->header('Content-Type', 'application/json')
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE);

    }

    public static function error(array $data = null, string $message = '', int $code = 500): JsonResponse
    {
        return Response::json([
            'success' => false,
            'message' => $message,
            'errors' => $data,
            'code' => $code
        ])
            ->setCharset('utf-8')
            ->header('Content-Type', 'application/json')
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE);

    }
}
