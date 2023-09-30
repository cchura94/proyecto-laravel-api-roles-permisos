<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthPassportController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\Social;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Redirect;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// sanctum
Route::prefix("v1/auth")->group(function(){

    Route::post("login", [AuthController::class, "funIngresar"]);
    Route::post("register", [AuthController::class, "funRegistro"]);

    Route::middleware('auth:sanctum')->group(function(){
        
        Route::get("profile", [AuthController::class, "funPerfil"]);
        Route::post("logout", [AuthController::class, "funSalir"]);
    });
    
});

// passport
Route::post("/passport/login", [AuthPassportController::class, "funIngresar"]);
Route::post("/passport/register", [AuthPassportController::class, "funRegistro"]);
Route::get("/passport/profile", [AuthController::class, "funPerfil"])->middleware('auth:api');

Route::middleware('auth:sanctum')->group(function(){
     // permiso
     Route::get("permiso/paginacion", [PermisoController::class, "indexPaginacion"]);
    // users
    Route::apiResource("users", UserController::class);
    Route::apiResource("permiso", PermisoController::class);
    Route::apiResource("role", RoleController::class);
 });

 Route::post("reset-password", [ResetPasswordController::class, "recuperarPassword"]);
 Route::post("cambio-password", [ResetPasswordController::class, "resetPassword"]);

 Route::get("/no-autorizado", function(){
    return response()->json(["message" => "Accion No autorizado"]);
 })->name("login");

 Route::get('/google-auth/redirect', function () {
    $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
    return response()->json(["url" => $url]);
});
 
Route::get('/google-auth/callback', function () {
    $user = Socialite::driver('google')->stateless()->user();

    if(!$user->token){
        return response()->json(["message" => "Error al autenticar"]);
    }

    $appUser = User::where('email', $user->email)->first();

    if(!$appUser){
        // nuevo usuario
        $appUser = new User();
        $appUser->name = $user->name;
        $appUser->email = $user->email;
        $appUser->password = Str::random(7);
        $appUser->save();

        $appUser->assignRole("anonimo");

        // 
        $newProvider = new Social();
        $newProvider->provider = "google";
        $newProvider->provider_user_id = $user->id;
        $newProvider->user_id = $appUser->id;
        $newProvider->save();

    }else{
        $sprovider = $appUser->sociales()->where('provider', 'google')->first();

        if(!$sprovider){
            $newProvider = new Social();
            $newProvider->provider = "google";
            $newProvider->provider_user_id = $user->id;
            $newProvider->user_id = $appUser->id;
            $newProvider->save();
        }

    }

    $token = $appUser->createToken('Social Token Google')->plainTextToken;


 
    return Redirect::to('http://localhost:5173/google-auth/callback?access_token='.$token);
    // $user->token
    // dd($user);
});
