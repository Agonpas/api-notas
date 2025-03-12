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

//ruta para obtener las notas medias de un estudiante
Route::get('/estudiantes/{id}/media', [EstudianteController::class, 'obtenerMediaNotas']);
//ruta para obtener las notas medias de una asignatura
Route::get('/asignaturas/{id}/media', [AsignaturaController::class, 'obtenerMediaNotasPorAsignatura']);
//ruta para obtener la media de todas las notas
Route::get('/media', [NotaController::class, 'obtenerMediaGlobal']);
//ruta para obtener todas las notas de un estudiante
Route::get('/estudiantes/{id}/notas', [\App\Http\Controllers\EstudianteController::class, 'obtenerNotas']);