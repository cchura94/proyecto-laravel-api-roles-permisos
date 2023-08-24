<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function recuperarPassword(Request $request){
        $request->validate([
            "email" => "required|email"
        ]);

        $status = Password::sendResetLink(
            $request->only("email")
        );

        if($status == Password::RESET_LINK_SENT){
            return ["status" => __($status)];
        }
    }

    public function resetPassword(Request $request){
        $request->validate([
            "token" => "required",
            "email" => "required|email",
            "password" => ["required", "confirmed", RulesPassword::default()]
        ]);

        $status = Password::reset(
            $request->only("email", "password", "password_confirmation", "token"), 
            function (User $user, string $password) {
                $user->forceFill([
                    "password" => Hash::make($password),
                    // "remember_token" => 'ran_'.time()
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if($status === Password::PASSWORD_RESET) {
            // $request->user()->tokens()->delete();

            return response([
                "message" => "La contraseña se ha modificado!"
            ]);
        }

        return response([
            "message" => __($status)
        ], 500);

    }
}
