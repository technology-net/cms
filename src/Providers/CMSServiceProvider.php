<?php

namespace IBoot\CMS\Providers;

use IBoot\Core\App\Models\Plugin;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

class CMSServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/cms.php', 'app'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'plugin/cms');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'plugin/cms');

        if (!Schema::hasTable('categories') || !Schema::hasTable('posts') || !Schema::hasTable('pages')) {
            Artisan::call('migrate');
            Artisan::call('optimize');
            $process = new Process(['composer', 'dump-autoload']);
            $process->run();
            exec('npm run dev');
        }

        $this->publishes([
            __DIR__ . '/../../../cms' => base_path(Plugin::PACKAGE_CMS),
        ], 'cms');
    }
}
