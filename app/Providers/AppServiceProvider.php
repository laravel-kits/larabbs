<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 注册观察者
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Reply::observe(\App\Observers\ReplyObserver::class);
        \App\Models\Topic::observe(\App\Observers\TopicObserver::class);
        \App\Models\Link::observe(\App\Observers\LinkObserver::class);
        \App\Models\Category::observe(\App\Observers\CategoryObserver::class);

        Schema::defaultStringLength(191); //Solved by increasing StringLength
        \Carbon\Carbon::setLocale('zh'); //Carbon 进行本地化的设置
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        if (app()->isLocal()) {
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }
    }
}
