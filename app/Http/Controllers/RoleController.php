<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::get();

        return response()->json($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|unique:roles"
        ]);

        $role = new Role;
        $role->nombre = $request->nombre;
        $role->detalle = $request->detalle;
        $role->save();

        return response()->json(["message" => "El rol ha sido registrado"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rol = Role::findOrFail($id);

        return response()->json($rol, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "nombre" => "required|unique:roles,nombre,$id"
        ]);

        $role = Role::findOrFail($id);
        $role->nombre = $request->nombre;
        $role->detalle = $request->detalle;
        $role->update();

        return response()->json(["message" => "El rol ha sido actualizado"], 201);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(["message" => "El rol ha sido eliminado"], 200);
    }
}
