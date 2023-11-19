<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerroController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/crearPerro', [PerroController::class, 'crear']);
Route::post('/editarPerro', [PerroController::class, 'update']);
Route::delete('/borrarPerro/{id}', [PerroController::class, 'eliminar']);
Route::get('/verPerros', [PerroController::class, 'verPerros']);
Route::get('/perroAleatorio', [PerroController::class, 'perroAleatorio']);