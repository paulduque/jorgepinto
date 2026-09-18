<?php

use App\Http\Controllers\Api\AgendaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ─────────────────────────────────────────────────────────
// API DE AGENDA (para n8n)
// ─────────────────────────────────────────────────────────
Route::middleware('auth:sanctum')->prefix('agenda')->group(function () {
    Route::post('/crear', [AgendaController::class, 'crear']);
    Route::get('/hoy', [AgendaController::class, 'hoy']);
    Route::get('/proximos', [AgendaController::class, 'proximos']);
    Route::get('/buscar', [AgendaController::class, 'buscar']);
    Route::put('/editar/{id}', [AgendaController::class, 'editar']);
    Route::delete('/eliminar/{id}', [AgendaController::class, 'eliminar']);
});
