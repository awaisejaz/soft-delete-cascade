<?php

namespace Awais\CascadeSoftDeletes\Providers;

use Awais\CascadeSoftDeletes\CascadeSoftDeletes\SoftDeleteScope;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

/**
 * Author: Awais Ejaz
 * Register Models for Global Scope
 */

class SoftDeleteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        if (app()->runningInConsole()) {
            $this->registerMigrations();

            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'soft-cascade-migrations');
        }

        # Register all model scope
        $models = File::files(app_path('/Models'));

        foreach ($models as $path) {
            $className = pathinfo($path)['filename'];
            $className = 'App\\Models\\' . $className;
            $className::addGlobalScope(new SoftDeleteScope);
        }
    }

    /**
     * Register sodt deleteable migration's files.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        return $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
