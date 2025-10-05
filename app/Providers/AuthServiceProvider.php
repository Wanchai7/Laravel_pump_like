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

        Gate::define('isOwner', function(User $user) {
            return $user->hasRole('owner');
        });

        Gate::define('isAdmin', function(User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('isUser', function(User $user) {
            return $user->hasRole('user');
        });

        Gate::define('update-product', function (User $user, Product $product) {
            return $user->id === $product->user_id;
        });

        Gate::define('delete-product', function (User $user, Product $product) {
            return $user->id === $product->user_id || $user->hasRole('admin') || $user->hasRole('owner');
        });
    }
}
