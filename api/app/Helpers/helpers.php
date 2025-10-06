<?php

use Illuminate\Http\JsonResponse;
use Spatie\Permission\Exceptions\UnauthorizedException;

if (!function_exists('api_success'))
{
    function api_success($data, string $message = "OK", int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code); // HTTP Code 200 - OK
    }
}

if (!function_exists('api_error'))
{
    function api_error(string $message = "Error", $errors = null, int $code = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $code); // HTTP Code 400 - Bad Request
    }
}

if (!function_exists('api_not_found'))
{
    function api_not_found(string $message): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 404); // HTTP Code 404 - Not Found
    }
}

if (!function_exists('api_unauthorized'))
{
    function api_unauthorized(string $message, int $code = 401): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code); // HTTP Code 401 - Unauthorized
    }
}

if (!function_exists('api_forbidden'))
{
    function api_forbidden(string $message): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 403); // HTTP Code 401 - Forbidden
    }
}

if (!function_exists('api_validation'))
{
    function api_validation(string $message, array $errors): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], 422); // HTTP Code 422 - Unprocessable Entity
    }
}

if (!function_exists('api_paginate'))
{
    function api_paginate($paginator, string $message): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $paginator->items(), // Items o elementos
            'meta' => [
                'current_page' => $paginator->currentPage(), // Número de páginas
                'per_page' => $paginator->perPage(), // Cuántos registros por página
                'total' => $paginator->total(), // Total de registros
                'last_page' => $paginator->lastPage(), // Última página disponible
            ],
        ]);
    }
}

if (!function_exists('api_no_content'))
{
    function api_no_content(string $message, $data): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], 204); // HTTP Code 204 - No Content
    }
}
