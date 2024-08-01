<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        Passport::routes();
        
        Gate::before(function ($user, $ability) {
            $roles  = DB::table('users')
                ->leftJoin('user_roles', 'user_roles.user_id', 'users.id')
                ->leftJoin('roles', 'roles.id', 'user_roles.role_id')
                ->where('users.id', $user->id)
                ->where('roles.role', 'Super Admin')
                ->count();
            
            if ($roles >= 1) {
                return true;
            }
        });
        
        Gate::define('isAdmin', function($user) {
            $roles  = DB::table('users')
                ->leftJoin('user_roles', 'user_roles.user_id', 'users.id')
                ->leftJoin('roles', 'roles.id', 'user_roles.role_id')
                ->where('users.id', $user->id)
                ->where('roles.role', 'Admin')
                ->count();
            
            if ($roles >= 1) {
                return true;
            } else {
                return false;
            }
        });
        
        Gate::define('isActive', function($user) {
            $active = DB::table('users')
                ->leftJoin('user_roles', 'user_roles.user_id', 'users.id')
                ->where('users.id', $user->id)
                ->whereNotNull('deleted_at')
                ->count();
            
            $banned = DB::table('users')
                ->leftJoin('user_roles', 'user_roles.user_id', 'users.id')
                ->leftJoin('roles', 'roles.id', 'user_roles.role_id')
                ->where('users.id', $user->id)
                ->where('roles.role', 'Banned')
                ->count();

            if (($active >= 1) and ($banned < 1)) {
                return true;
            } else {
                return false;
            }
        });
    }
}
