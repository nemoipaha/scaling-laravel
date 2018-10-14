<?php

namespace App\Providers;

use App\Analytics\Pageview;
use App\Analytics\Pageviews;
use App\Analytics\PageviewCache;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Horizon::auth(function ($request) {
            $user = $request->user();

            return $user ? $user->email === 'admin@email.com' : false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Pageview::class, function($app)
        {
            return new PageviewCache(
                new Pageviews(auth()->user())
            );
        });
    }
}
