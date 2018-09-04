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
