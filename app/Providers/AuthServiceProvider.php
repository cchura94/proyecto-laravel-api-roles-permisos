<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // user = 5
        // permiso = index_user
        Gate::before(function($user, $permiso){
            // permiso: index_user, store_user, update_user, delete_user
            // echo($user->permisos()->contains('manage_all'));
            if($user->permisos()->contains('manage_all')){
                return true;
            }
            return $user->permisos()->contains($permiso);
        });
    }
}
