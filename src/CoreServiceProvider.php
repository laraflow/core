<?php

namespace Laraflow\Core;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Laraflow\Core\Commands\RepositoryMakeCommand;
use Laraflow\Core\Commands\ServiceMakeCommand;
use Laraflow\Core\Http\Response\XmlResponse;

/**
 * Class CoreServiceProvider
 */
class CoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //config
        $this->publishes([
            __DIR__.'/../config/core.php' => config_path('core.php'),
            __DIR__.'/../config/xml.php' => config_path('xml.php'),
            __DIR__.'/../config/audit.php' => config_path('audit.php'),
        ], 'core-config');

        //view
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'core');
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/core'),
        ], 'core-view');

        /*//route
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        //migration
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        //translation
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'core');

        $this->publishes([
            __DIR__ . '/../resources/lang' => $this->app->langPath('vendor/core/lang'),
        ], 'core-lang');


        //asset
        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/core'),
        ], 'core-asset');*/

        $this->loadMacro();
        $this->loadDirective();
        $this->loadBinding();
    }

    public function register()
    {
        //config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/core.php', 'core'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/xml.php', 'xml'
        );
    }

    private function loadMacro()
    {
        Response::macro('xml', function ($value, $status = 200, $config = []) {
            return (new XmlResponse())->array2xml($value, false, $config, $status);
        });

        Blueprint::macro('blameable', function () {
            $this->unsignedBigInteger(
                config('core.blame.createdBy', 'created_by'))
                ->nullable()
                ->default(null);

            $this->unsignedBigInteger(
                config('core.blame.updatedBy', 'updated_by'))
                ->nullable()
                ->default(null);

            $this->unsignedBigInteger(
                config('core.blame.deletedBy', 'deleted_by'))
                ->nullable()
                ->default(null);

        });
    }

    private function loadDirective()
    {
        Blade::directive('money', function ($string) {
            return "<?php echo  \Laraflow\Core\Services\Utilities\MoneyService::format({$string}); ?>";
        });
    }

    private function loadBinding()
    {
        $this->app->bind('xml', function () {
            return new XmlResponse();
        });
    }

    private function loadCommands()
    {
        $this->commands([
            RepositoryMakeCommand::class,
            ServiceMakeCommand::class,
        ]);
    }
}
