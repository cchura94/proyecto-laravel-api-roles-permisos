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
        $this->authorize("index_permiso");
        $permisos = Permiso::get();

        return response()->json($permisos);
    }

    public function indexPaginacion(Request $request) {

        $this->authorize("index_permiso");
        // /api/permiso?page=2&limit=20&q=user
        $limit = isset($request->limit)?$request->limit:10;
        if(isset($request->q)){
            // buscar
            $permisos = Permiso::with('roles')->where('nombre', 'like', '%'.$request->q.'%')
                                ->orWhere('subject', 'like', "%$request->q%")
                                ->orWhere('detalle', 'like', "%$request->q%")
                                ->paginate($limit);

        }else{
            $permisos = Permiso::with('roles')->paginate($limit);
        }
        return response()->json($permisos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $this->authorize("store_permiso");

        $request->validate([
            "nombre" => "required|unique:permisos"
        ]);

        $permiso = new Permiso();
        $permiso->nombre = $request->nombre;
        $permiso->action = $request->action;
        $permiso->subject = $request->subject;
        $permiso->detalle = $request->detalle;
        $permiso->save();

        return response()->json(["message" => "El Permiso ha sido registrado"], 201);
   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize("show_permiso");

        $permiso = Permiso::findOrFail($id);

        return response()->json($permiso, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize("update_permiso");

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
        $this->authorize("delete_permiso");

        $permiso = Permiso::findOrFail($id);
        $permiso->delete();

        return response()->json(["message" => "El Permiso ha sido eliminado"], 200);
    
    }
}
