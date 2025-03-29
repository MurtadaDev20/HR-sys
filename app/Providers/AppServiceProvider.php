<?php

namespace App\Providers;
// use Filament\Filament;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerRenderHook(
                'head.start',
                fn (): string => '
                    <style>
                        body {
                            direction: rtl;
                            text-align: right;
                        }
                        .fi-sidebar {
                            right: 0 !important;
                            left: auto !important;
                            border-left: none !important;
                            border-right: 1px solid #e5e7eb !important;
                        }
                        .fi-main {
                            margin-left: 0 !important;
                            margin-right: var(--sidebar-width, 16rem) !important;
                        }
                    </style>
                ',
            );
        });
    }
}
