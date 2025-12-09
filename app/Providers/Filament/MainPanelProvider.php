<?php

namespace App\Providers\Filament;

use App\Filament\Main\Pages\Homepage;
use DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin;
use DutchCodingCompany\FilamentSocialite\Provider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class MainPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('main')
            ->path('santa')
            ->brandName("🎄 Crimbus at Dot's")
            ->login()
            ->navigation(false)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Main/Resources'), for: 'App\Filament\Main\Resources')
            ->discoverPages(in: app_path('Filament/Main/Pages'), for: 'App\Filament\Main\Pages')
            ->pages([
                Homepage::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Main/Widgets'), for: 'App\Filament\Main\Widgets')
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
            ])
            ->plugin(
                FilamentSocialitePlugin::make()
                    // (required) Add providers corresponding with providers in `config/services.php`.
                    ->providers([
                        // Create a provider 'gitlab' corresponding to the Socialite driver with the same name.
                        Provider::make('telegram')
                            ->label('Telegram')
                            ->icon('si-telegram')
                            ->color(Color::hex('#2f2a6b'))
                            ->outlined(false)
                            ->stateless(false)
                            ->scopes(['...'])
                            ->with(['...']),
                    ])
                // (optional) Override the panel slug to be used in the oauth routes. Defaults to the panel's configured path.
                // (optional) Enable/disable registration of new (socialite-) users.
                // (optional) Enable/disable registration of new (socialite-) users using a callback.
                // In this example, a login flow can only continue if there exists a user (Authenticatable) already.
            );
    }
}
