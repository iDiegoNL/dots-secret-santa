<?php

namespace App\Filament\Auth;

use App\Models\User;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Auth\SessionGuard;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Maize\Encryptable\Encryption;
use SensitiveParameter;

class Login extends BaseLogin
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns()
            ->components([
                TextInput::make('name')
                    ->required()
                    ->autocomplete('off'),

                TextInput::make('login_code')
                    ->required()
                    ->placeholder('Your login code')
                    ->password()
                    ->revealable()
                    ->autocomplete('off'),
            ]);
    }

    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        /** @var SessionGuard $authGuard */
        $authGuard = Filament::auth();

        $credentials = $this->getCredentialsFromFormData($data);

        try {
            $user = User::query()
                ->where('decoded_name', $credentials['name'])
                ->where('login_code', Encryption::php()->encrypt($credentials['login_code']))
                ->firstOrFail();
        } catch (ModelNotFoundException) {
            $this->userUndertakingMultiFactorAuthentication = null;

            $this->fireFailedEvent(
                guard: $authGuard,
                user: null,
                credentials: $credentials
            );

            $this->throwFailureValidationException();
        }

        $authGuard->login(
            user: $user,
            remember: true
        );

        session()->regenerate();

        return app(LoginResponse::class);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function getCredentialsFromFormData(#[SensitiveParameter] array $data): array
    {
        return [
            'name' => $data['name'],
            'login_code' => preg_replace('/\s+/', '', $data['login_code']), // Remove all whitespaces from login code
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.login_code' => __('filament-panels::auth/pages/login.messages.failed'),
        ]);
    }
}
