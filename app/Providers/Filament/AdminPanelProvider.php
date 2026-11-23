<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Filament\Widgets\BarChartWidget;
use App\Filament\Widgets\DoughnutChartWidget;
use App\Filament\Widgets\MapWidget;
use App\Filament\Widgets\StatsWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandLogo(asset('img/logo-green.png'))
            ->darkModeBrandLogo(asset('img/logo-white.png'))
            ->brandLogoHeight('2.5rem')
            ->sidebarCollapsibleOnDesktop()
            ->renderHook(
                PanelsRenderHook::USER_MENU_BEFORE,
                fn() => Blade::render('
                    <div class="hidden sm:flex flex-col text-right mr-3">
                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ auth()->user()->name }}
                        </span>
                    </div>
                ')
            )
            ->renderhook(
                PanelsRenderHook::SIMPLE_PAGE_START,
                fn(): string => Blade::render('
                <div style="width: 100%; display: flex; justify-content: center; align-items: center; margin-bottom: 1rem;">
                    <img src="' . asset('img/logo-login.png') . '" 
                        alt="Logo Login" 
                        style="height: 100px !important; width: auto !important;" />
                </div>
                ')
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn(): string => Blade::render('
                @if (request()->routeIs(\'filament.admin.auth.login\'))     
                    <style>
                        .fi-logo,
                        a[href*="admin"] > img {
                            display: none !important;
                        }
                    </style>
                @endif
                ')
            )
            ->colors([
                'primary' => Color::Neutral,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            // ->maxContentWidth('full')
            ->widgets([
                StatsWidget::class,
                BarChartWidget::class,
                DoughnutChartWidget::class,
                MapWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
