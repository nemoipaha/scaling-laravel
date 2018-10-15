<?php

namespace App\Providers;

use App\Analytics\Pageview;
use App\Analytics\Pageviews;
use App\Analytics\PageviewCache;
use App\Queue\SqsConnector;
use Illuminate\Support\Facades\Queue;
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

        Queue::extend(
            'my-sqs',
            function () {
                return new SqsConnector();
            }
        );
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
