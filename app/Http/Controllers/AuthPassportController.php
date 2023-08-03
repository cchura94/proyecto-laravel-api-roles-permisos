<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthPassportController extends Controller
{
    public function funIngresar(Request $request){
        $credenciales = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        if(!Auth::attempt($credenciales)){
            return response()->json(["message" => "No Autenticado"]);
        }
        
        $usuario = Auth::user();

        $token = $usuario->createToken("token personal Passport")->accessToken;

        return response()->json(["access_token" => $token, "user" => $usuario]);
    }

    public function funRegistro(Request $request){
        
    }

}
