<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asignatura;

class AsignaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Asignatura::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'curso' => 'required|in:1o,2o,3o,4o'
        ]);

        $asignatura = Asignatura::create($request->all());
        return response()->json($asignatura, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $asignatura = Asignatura::findOrFail($id);
        return response()->json($asignatura);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $asignatura = Asignatura::findOrFail($id);

        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'curso' => 'sometimes|in:1o,2o,3o,4o'
        ]);

        $asignatura->update($request->all());
        return response()->json($asignatura);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Asignatura::destroy($id);
        return response()->json(null, 204);
    }
}
