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
        //防止限制长度
        Schema::defaultStringLength(191);
        \View::composer('layout.sidebar',function($view){
            $topics = \App\Topic::all();
            $view->with('topics',$topics);
        });
        
        //权限控制
        
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
