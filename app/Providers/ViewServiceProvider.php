<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('routesJson', json_encode([
                'properties' => [
                    'create' => route('properties.create'),
                    'update' => route('properties.update', ['property' => 'PROPERTY_ID']),
                    'edit' => route('properties.edit', ['property' => 'PROPERTY_ID']),
                    'read' => route('properties.read', ['property' => 'PROPERTY_ID']),
                    'delete' => route('properties.delete', ['property' => 'PROPERTY_ID']),
                    'search' => route('properties.search_near'),
                ],
            ]));
        });
    }
}
