<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Nota;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Estudiante::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'edad' => 'required|integer|min:0'
        ]);

        $estudiante = Estudiante::create($request->all());
        return response()->json($estudiante, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $estudiante = Estudiante::findOrFail($id);
        return response()->json($estudiante);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        $estudiante = Estudiante::findOrFail($id);

        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'apellidos' => 'sometimes|string|max:255',
            'edad' => 'sometimes|integer|min:0'
        ]);
        
        $estudiante->update($request->all());

        return response()->json($estudiante);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Estudiante::destroy($id);
        return response()->json(null, 204);
    }

    /* método para obtener las notas medias de un estudiante */
    public function obtenerMediaNotas(string $id)
    {
        $estudiante = Estudiante::findOrFail($id);

        $notas = $estudiante->notas;
        $media = $notas->avg('nota');

        return response()->json([
            'estudiante' => $estudiante -> nombre . ' ' . $estudiante -> apellidos,
            'media' => $media
        ]);
    }
    public function obtenerNotas(string $id)
    {
        $estudiante = Estudiante::findOrFail($id);

         $notas = Nota::where('estudiante_id', $id)
                ->with('asignatura:id,nombre') 
                ->get(['asignatura_id', 'nota']);

        $resultado = $notas->map(function ($nota) {
            return [
                'asignatura' => $nota->asignatura->nombre,
                'nota' => $nota->nota
            ];
        });
            
                return response()->json($resultado);
            
    }
}
