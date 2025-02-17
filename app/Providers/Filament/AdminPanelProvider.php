<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Widgets\LineChartWidget;
use App\Filament\Widgets\LineChartWidget2;
use App\Filament\Widgets\ChartDummyWidget;
use App\Filament\Widgets\CustomerTableWidget;
use App\Filament\Widgets\ProductTableWidget;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin; // ✅ Import the ApexCharts Plugin

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->renderHook(
                'panels::body.end',
                fn () => view('components.export-button')
            )
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            // ✅ Register the ApexCharts Plugin here
            ->plugin(FilamentApexChartsPlugin::make()) 
            // Register widgets
            ->widgets([
                LineChartWidget::class,
                LineChartWidget2::class,
                CustomerTableWidget::class,
                ProductTableWidget::class,
            ])
            ->renderHook(
                'panels::auth.login.form.after',
                fn () => view('auth.socialite.google')
            )
            // Discover resources, pages, and widgets
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
                \App\Filament\Pages\ChartDashboard::class
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            // Middleware
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
