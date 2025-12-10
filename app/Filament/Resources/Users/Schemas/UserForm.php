<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name (in binary)')
                    ->required()
                    ->string()
                    ->suffixAction(
                        Action::make('decode')
                            ->icon('heroicon-o-eye')
                            ->action(function (?string $state, Field $component) {
                                $component->helperText(decode_binary($state));
                            }),
                    ),

                TextInput::make('login_code')
                    ->formatStateUsing(fn (User $record) => $record->login_code),

                Toggle::make('is_participating')
                    ->label('Participating in Secret Santa')
                    ->required()
                    ->default(true),
            ]);
    }
}
