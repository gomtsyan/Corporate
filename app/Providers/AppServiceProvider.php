<?php

namespace Corp\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('set', function($exp) {
            list($name, $value) = explode(',', $exp);

            return "<?php $name = $value ?>";
        });

        DB::listen(function($query) {
            //echo '<h1>'.$query->sql.'</h1>';
        });
    }
}
