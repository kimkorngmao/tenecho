<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::composer('*', function ($view) {
            // all siteSettings
            $siteSettings = \App\Models\SiteSetting::all();
            $categories = \App\Models\Category::orderBy('order', 'asc')->where('parent_id', null)->get();
            $latestNews = \App\Models\Article::where('type', 'news')
                ->where('status', 'published')
                ->latest()
                ->first();
                
            $view->with('siteSettings', $siteSettings);
            $view->with('categories', $categories);
            $view->with('latestNews', $latestNews);
        });
    }
}
