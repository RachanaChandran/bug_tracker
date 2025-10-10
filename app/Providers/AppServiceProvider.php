<?php

namespace App\Providers;

use App\Policies\IssuePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate::policy(User::class, IssuePolicy::class);
        Gate::define('isAdmin', fn($user) => $user->name === 'admin');
        Gate::define('istester', fn($user) => $user->name === 'tester');
    }
}
