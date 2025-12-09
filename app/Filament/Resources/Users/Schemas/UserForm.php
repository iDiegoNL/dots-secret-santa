<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

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

                Select::make('givingTo')
                    ->label('Giving gift to')
                    ->relationship(
                        name: 'givingTo',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->doesntHave('receivingFrom'),
                        ignoreRecord: true
                    )
                    ->searchable()
                    ->preload()
                    ->optionsLimit(999)
                    ->placeholder('Not assigned yet'),

                Toggle::make('is_participating')
                    ->label('Participating in Secret Santa')
                    ->required()
                    ->default(true),
            ]);
    }
}
