<?php

namespace App\Providers;

use App\Auth\SupabaseGuard;
use App\Services\SupabaseAuthService;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Auth::extend('supabase', function ($app, $name, array $config) {
            $guard = new SupabaseGuard(
                $app['auth']->createUserProvider($config['provider']),
                $app['session.store'],
                $app->make(SupabaseAuthService::class)
            );

            $app->refresh('request', $guard, 'setRequest');

            return $guard;
        });
    }
}
