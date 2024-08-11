<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Task;
use App\Models\UserRole;
use App\Policies\TaskPolicy;
use App\Policies\UserRolePolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;



class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Task::class => TaskPolicy::class,
        UserRole::class => UserRolePolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
