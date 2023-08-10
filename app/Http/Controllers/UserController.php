<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /*
        if(!$request->user()->can("listar_user")){
            abort(403);
        }
        */
        $this->authorize("index_user");
        // /api/user?limit=5&page=2&q=juan
        $limit = isset($request->limit)?$request->limit:10;
        $buscar = isset($request->q)?$request->q:null;
        if($buscar){
            $usuarios = User::orderBy("id", "desc")
                                ->where("email", "like", "%$buscar%")
                                ->paginate($limit);
        }else{
            $usuarios = User::orderBy("id", "desc")->paginate($limit);

        }

        return response()->json($usuarios, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize("store_user");

        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required"
        ]);

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        return response()->json(["message" => "Usuario Registrado"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize("show_user");

        $usuario = User::findOrFail($id);
        return response()->json($usuario, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $this->authorize("update_user");

        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email,$id"
        ]);

        $usuario = User::findOrFail($id);
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        if(isset($request->password)){
            $usuario->password = bcrypt($request->password);
        }
        $usuario->update();

        return response()->json(["message" => "Usuario Actualizado"], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize("delete_user");

        $usuario = User::findOrFail($id);
        $usuario->delete();

        return response()->json(["message" => "Usuario Eliminado"]);
    }
}
