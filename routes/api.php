<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\NotaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('estudiantes', EstudianteController::class);
Route::apiResource('asignaturas', AsignaturaController::class);
Route::apiResource('notas', NotaController::class);
