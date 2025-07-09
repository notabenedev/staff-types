<?php

namespace Notabenedev\StaffTypes;

use App\StaffType;
use Illuminate\Support\ServiceProvider;
use Notabenedev\StaffTypes\Console\Commands\StaffTypesMakeCommand;

class StaffTypesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/staff-types.php', 'staff-types'
        );

        // Facades
        $this->app->singleton("staff-param-unit-actions", function () {
            $class = config("staff-types.paramUnitFacade");
            return new $class;
        });
        $this->app->singleton("staff-type-actions", function () {
            $class = config("staff-types.typeFacade");
            return new $class;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Публикация конфигурации
        $this->publishes([
            __DIR__.'/config/staff-types.php' => config_path('staff-types.php')
        ], 'config');

        // Подключение миграции
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // Console
        if ($this->app->runningInConsole()){
            $this->commands([
                StaffTypesMakeCommand::class,
            ]);
        }
        // Подключаем роуты
        if (config("staff-types.staffTypesAdminRoutes")) {
            $this->loadRoutesFrom(__DIR__."/routes/admin/staff-type.php");
            $this->loadRoutesFrom(__DIR__."/routes/admin/staff-param-unit.php");
            $this->loadRoutesFrom(__DIR__."/routes/admin/staff-param-name.php");
        }

        // Подключение шаблонов.
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'staff-types');

        view()->composer([
            "staff-types::admin.staff-param-units.create",
            "staff-types::admin.staff-param-units.edit",

        ], function ($view){
            $types = StaffType::all();
            $view->with("types", $types);
        });

    }
}
