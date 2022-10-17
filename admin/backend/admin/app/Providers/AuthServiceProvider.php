<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('view', function ($user, $model) {
            $userRole = UserRole::where('user_id',$user->id)->first();
        $role = Role::find($userRole->role_id)->first();
            $permission = $role->permissions->pluck('name');
            return $permission->contains("view{$model}") || $permission->contains("edit_{$model}");
        });

        Gate::define('edit', function ($user, $model) {
            $userRole = UserRole::where('user_id',$user->id)->first();
            $role = Role::find($userRole->role_id)->first();
            $permission = $role->permissions->pluck('name');
            return $permission->contains("edit_{$model}");
        });
    }
}
