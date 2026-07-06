<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $tempDir = storage_path('framework/temp');
        if (! is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        ini_set('sys_temp_dir', $tempDir);
        ini_set('upload_tmp_dir', $tempDir);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
