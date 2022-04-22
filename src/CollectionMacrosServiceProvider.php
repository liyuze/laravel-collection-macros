<?php

namespace Liyuze\CollectionMacros;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Liyuze\CollectionMacros\Macros\IfMacros;

class CollectionMacrosServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('collection-macros.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'collection-macros');

        // macros alias
        $aliases = config('collection-macros.alias');

        // macro register
        collect($this->macros())
            ->mapWithKeys(function ($func, $macro) use ($aliases) {
                return [$this->replaceMacroName($macro, $aliases) => $func];
            })
            ->reject(function ($func, $macro) {
                return Collection::hasMacro($macro);
            })
            ->each(function ($func, $macro) {
                Collection::macro($macro, $func);
            });
    }

    public function replaceMacroName($macroName, $aliases)
    {
        return $aliases[$macroName] ?? $macroName;
    }

    public function macros()
    {
        return [
            'ifThen'     => IfMacros::ifThen(),
            'unlessThen' => IfMacros::unlessThen(),
        ];
    }
}
