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
         \Corp\Article::class => \Corp\Policies\ArticlePolicy::class,
         \Corp\Permission::class => \Corp\Policies\PermissionPolicy::class,
         \Corp\Menu::class => \Corp\Policies\MenusPolicy::class,
         \Corp\User::class => \Corp\Policies\UserPolicy::class,
         \Corp\Portfolio::class => \Corp\Policies\PortfolioPolicy::class,
         \Corp\Contact::class => \Corp\Policies\ContactPolicy::class,
         \Corp\Slider::class => \Corp\Policies\SliderPolicy::class,
         \Corp\Category::class => \Corp\Policies\CategoryPolicy::class,
         \Corp\Filter::class => \Corp\Policies\FilterPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('VIEW_ADMIN', function($user) {
            return $user->canDo(['VIEW_ADMIN'], false);
        });

        Gate::define('VIEW_ADMIN_ARTICLES', function($user) {
            return $user->canDo(['VIEW_ADMIN_ARTICLES'], false);
        });

        Gate::define('ADD_ARTICLES', function($user) {
            return $user->canDo(['ADD_ARTICLES'], false);
        });

        Gate::define('EDIT_USERS', function($user) {
            return $user->canDo(['EDIT_USERS'], false);
        });

        Gate::define('EDIT_PERMISSIONS', function($user) {
            return $user->canDo(['EDIT_PERMISSIONS'], false);
        });

        Gate::define('VIEW_ADMIN_MENU', function($user) {
            return $user->canDo(['VIEW_ADMIN_MENU'], false);
        });

        Gate::define('EDIT_MENU', function($user) {
            return $user->canDo(['EDIT_MENU'], false);
        });

        Gate::define('EDIT_USERS', function($user) {
            return $user->canDo(['EDIT_USERS'], false);
        });

        Gate::define('ADMIN_USERS', function($user) {
            return $user->canDo(['ADMIN_USERS'], false);
        });

        Gate::define('VIEW_ADMIN_PORTFOLIOS', function($user) {
            return $user->canDo(['VIEW_ADMIN_PORTFOLIOS'], false);
        });

        Gate::define('ADD_PORTFOLIOS', function($user) {
            return $user->canDo(['ADD_PORTFOLIOS'], false);
        });

        Gate::define('UPDATE_PORTFOLIOS', function($user) {
            return $user->canDo(['UPDATE_PORTFOLIOS'], false);
        });

        Gate::define('DELETE_PORTFOLIOS', function($user) {
            return $user->canDo(['DELETE_PORTFOLIOS'], false);
        });

        Gate::define('VIEW_ADMIN_SLIDER', function($user) {
            return $user->canDo(['VIEW_ADMIN_PORTFOLIOS'], false);
        });

        Gate::define('ADD_SLIDER', function($user) {
            return $user->canDo(['ADD_SLIDER'], false);
        });

        Gate::define('UPDATE_SLIDER', function($user) {
            return $user->canDo(['UPDATE_SLIDER'], false);
        });

        Gate::define('DELETE_SLIDER', function($user) {
            return $user->canDo(['DELETE_SLIDER'], false);
        });

        Gate::define('VIEW_ADMIN_CONTACTS', function($user) {
            return $user->canDo(['VIEW_ADMIN_CONTACTS'], false);
        });

        Gate::define('ADD_CONTACTS', function($user) {
            return $user->canDo(['ADD_CONTACTS'], false);
        });

        Gate::define('UPDATE_CONTACTS', function($user) {
            return $user->canDo(['UPDATE_CONTACTS'], false);
        });

        Gate::define('ADD_FILTER', function($user) {
            return $user->canDo(['ADD_FILTER'], false);
        });

        Gate::define('ADD_CATEGORY', function($user) {
            return $user->canDo(['ADD_CATEGORY'], false);
        });

        Gate::define('EDIT_FILTER', function($user) {
            return $user->canDo(['ADD_FILTER'], false);
        });

        Gate::define('EDIT_CATEGORY', function($user) {
            return $user->canDo(['ADD_CATEGORY'], false);
        });
    }
}
