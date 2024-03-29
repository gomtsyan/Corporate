<?php

namespace Corp\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Corp\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::pattern('alias', '[\w-]+');

        parent::boot();

        Route::bind('article', function($value) {
            return \Corp\Article::where('alias', $value)->first();
        });

        Route::bind('portfolio', function($value) {
            return \Corp\Portfolio::where('alias', $value)->first();
        });

        Route::bind('menu', function($value) {
            return \Corp\Menu::where('id', $value)->first();
        });

        Route::bind('users', function($value) {
            return \Corp\User::find($value)->first();
        });

        Route::bind('contact', function($value) {
            return \Corp\Contact::where('id', $value)->first();
        });

        Route::bind('slider', function($value) {
            return \Corp\Slider::where('id', $value)->first();
        });

        Route::bind('category', function($value) {
            return \Corp\Category::where('id', $value)->first();
        });

        Route::bind('filter', function($value) {
            return \Corp\Filter::where('id', $value)->first();
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
