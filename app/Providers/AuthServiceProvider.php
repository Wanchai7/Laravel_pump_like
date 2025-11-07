<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
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
        $this->registerPolicies();

        Gate::before(function (User $user, string $ability) {
            if ($user->hasRole('owner')) {
                return true;
            }
        });

        Gate::define('isOwner', function(User $user) {
            return $user->hasRole('owner');
        });

        Gate::define('isAdmin', function(User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('isUser', function(User $user) {
            return $user->hasRole('user');
        });

        Gate::define('create-product', function (User $user) {
            return $user->hasRole('owner') || $user->hasRole('admin');
        });

        Gate::define('update-product', function (User $user, Product $product) {
            if ($user->hasRole('owner') || $user->hasRole('admin')) {
                return true;
            }

            return $user->id === $product->user_id;
        });

        Gate::define('delete-product', function (User $user, Product $product) {
            if ($user->hasRole('owner') || $user->hasRole('admin')) {
                return true;
            }

            return $user->id === $product->user_id;
        });
    }
}
