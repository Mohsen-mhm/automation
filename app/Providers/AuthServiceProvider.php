<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Permission;
use App\Models\Role;
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

    protected function getPermission()
    {
        try {
            return Permission::with('roles')->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        foreach ($this->getPermission() as $permission) {
            Gate::define($permission->name, static function ($user) use ($permission) {
                return $user->hasRole($permission->roles);
            });
        }
        Gate::define('chart-permissions', static function ($user) {
            return $user->hasRole(Role::ADMIN_ROLE);
        });
    }
}
