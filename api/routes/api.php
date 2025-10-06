<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TipoMercanciaController;
use App\Http\Controllers\EstadoPaqueteController;
use App\Http\Controllers\CamionController;
use App\Http\Controllers\CamioneroController;
use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\DetallePaqueteController;
use Illuminate\Support\Facades\Route;

// API - Rutas públicas
Route::post('/users/register', [AuthController::class, 'register']);
Route::post('/users/login', [AuthController::class, 'login']);

// API - Cerrar sesión, se requiere Bearer Token
Route::middleware(['auth:sanctum'])->post('/users/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // API - Tipos de Mercancías
    Route::apiResource('tipos_mercancias', TipoMercanciaController::class)
        ->parameters([
            'tipos_mercancias' => 'id'
        ]);

    // API - Estados de Paquetes
    Route::apiResource('estados_paquetes', EstadoPaqueteController::class)
        ->parameters([
            'estados_paquetes' => 'id'
        ]);

    // API - Camiones
    Route::apiResource('camiones', CamionController::class)
        ->parameters([
            'camiones' => 'id'
        ]);

    // API - Camioneros
    Route::apiResource('camioneros', CamioneroController::class)
        ->parameters([
            'camioneros' => 'id'
        ]);
});

Route::middleware(['auth:sanctum', 'role:admin|camionero'])->group(function () {
    // API - Paquetes
    Route::apiResource('paquetes', PaqueteController::class)
        ->parameters([
            'paquetes' => 'paquete'
        ]);

    // API - Detalles de Paquetes
    Route::apiResource('detalles_paquetes', DetallePaqueteController::class)
        ->parameters([
            'detalles_paquetes' => 'detalle_paquete'
        ]);
});
