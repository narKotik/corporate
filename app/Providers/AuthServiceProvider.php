<?php

namespace Corp\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;



class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'Corp\Model' => 'Corp\Policies\ModelPolicy',
        'Corp\Article' => 'Corp\Policies\ArticlePolicy',
        'Corp\Permission' => 'Corp\Policies\PermitionPolicy',
        'Corp\Menu' => 'Corp\Policies\MenuPolicy',
        'Corp\User' => 'Corp\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('VIEW_ADMIN', function ($user){
            return $user->canDo('VIEW_ADMIN');
        });

        Gate::define('VIEW_ADMIN_ARTICLES', function ($user){
            return $user->canDo('VIEW_ADMIN_ARTICLES');
        });
        Gate::define('EDIT_USERS', function ($user){
            return $user->canDo('EDIT_USERS');
        });
        Gate::define('VIEW_ADMIN_MENU', function ($user){
            return $user->canDo('VIEW_ADMIN_MENU');
        });
        Gate::define('VIEW_ADMIN_USERS', function ($user){
            return $user->canDo('VIEW_ADMIN_USERS');
        });
        //
    }
}
