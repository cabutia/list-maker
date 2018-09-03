<?php

namespace LeandroGRG\ListMaker\Providers;

use Illuminate\Support\ServiceProvider;

class ListMakerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->publishes([
        //     __DIR__ . '/../Migrations/' => database_path('migrations')
        // ], 'migrations');
        //
        $this->publishes([
            __DIR__ . '/../config.php' => config_path('listmaker.php')
        ], 'config');
        //
        // $this->publishes([
        //     __DIR__ . '/../Models/' => app_path()
        // ], 'models');

        $this->publishes([
            __DIR__ . '/../Templates' => 'app/Helpers/ListTemplates'
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/../Migrations');
        $this->commands([
            \LeandroGRG\ListMaker\Commands\CreateList::class,
            \LeandroGRG\ListMaker\Commands\CreateListItem::class,
            \LeandroGRG\ListMaker\Commands\DeleteList::class,
            \LeandroGRG\ListMaker\Commands\DeleteListItem::class
        ]);
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
