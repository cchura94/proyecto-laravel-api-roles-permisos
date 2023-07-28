<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permisos = Permiso::get();

        return response()->json($permisos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|unique:permisos"
        ]);

        $permiso = new Permiso();
        $permiso->nombre = $request->nombre;
        $permiso->detalle = $request->detalle;
        $permiso->save();

        return response()->json(["message" => "El Permiso ha sido registrado"], 201);
   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permiso = Permiso::findOrFail($id);

        return response()->json($permiso, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "nombre" => "required|unique:permisos,nombre,$id"
        ]);

        $permiso = Permiso::findOrFail($id);
        $permiso->nombre = $request->nombre;
        $permiso->detalle = $request->detalle;
        $permiso->update();

        return response()->json(["message" => "El Permiso ha sido actualizado"], 201);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permiso = Permiso::findOrFail($id);
        $permiso->delete();

        return response()->json(["message" => "El Permiso ha sido eliminado"], 200);
    
    }
}
