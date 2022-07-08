<?php

namespace Laraflow\Core;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class MoneyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('money', function ($string) {
            return "<?php echo  \Laraflow\Core\Services\Utilities\MoneyService::format({$string}); ?>";
        });
    }
}
