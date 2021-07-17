<?php

namespace TechnoBureau\UI\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class TechnoBureauAuthServiceProvider extends ServiceProvider
{
    /**
     * If User are in super-admin Group then have permission by default without special allocation.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
 
        Gate::before(function ($user, $ability) {
            return $user->hasGroup('super-admin') ? true : null;
        });

    }
}
