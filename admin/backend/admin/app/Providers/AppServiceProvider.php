<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\UserRole;
use Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('view', function ($user, $model) {
            $userRole = UserRole::where('user_id',$user->id)->first();
            $role = Role::find($userRole->role_id);
            $permissions = $role->permissions->plunk('name');
            return $permissions->contains('view_'. $model) || $permissions->contains('edit_'. $model);
        });
        Gate::define('edit', function ($user, $model) {
            $userRole = UserRole::where('user_id',$user->id)->first();
            $role = Role::find($userRole->role_id);
            $permissions = $role->permissions->plunk('name');
            return $permissions->contains('edit_'. $model);
        });
    }
}
