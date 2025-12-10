<?php

namespace App\Filament\Main\Widgets;

use App\Models\User;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;
use Illuminate\Support\Str;

class GivingToWidget extends Widget implements HasSchemas
{
    use InteractsWithSchemas;

    protected string $view = 'filament.main.widgets.giving-to-widget';

    public ?User $givingTo = null;

    public function givingToInfolist(Schema $schema): Schema
    {
        return $schema
            ->record($this->givingTo->giftHints)
            ->components([
                Grid::make()
                    ->schema([
                        Fieldset::make('Their favourites')
                            ->columns()
                            ->schema([
                                TextEntry::make('foods')
                                    ->placeholder('-'),
                                TextEntry::make('drinks')
                                    ->placeholder('-'),
                                TextEntry::make('snacks')
                                    ->placeholder('-'),
                                TextEntry::make('candies')
                                    ->placeholder('-'),
                                TextEntry::make('restaurants')
                                    ->placeholder('-'),
                                TextEntry::make('colors')
                                    ->placeholder('-'),
                                TextEntry::make('scents')
                                    ->placeholder('-'),
                                TextEntry::make('sports')
                                    ->placeholder('-'),
                                TextEntry::make('stores')
                                    ->placeholder('-'),
                                TextEntry::make('books')
                                    ->placeholder('-'),
                                TextEntry::make('music')
                                    ->placeholder('-'),
                                TextEntry::make('hobbies')
                                    ->placeholder('-'),
                            ]),

                        Group::make()
                            ->schema([
                                Fieldset::make('Their preferences')
                                    ->columns(1)
                                    ->schema([
                                        TextEntry::make('preferences')
                                            ->hiddenLabel()
                                            ->bulleted()
                                            ->formatStateUsing(fn (string $state) => Str::of($state)->replace('_', ' ')->ucwords()),
                                    ]),

                                Fieldset::make('This or that')
                                    ->columns()
                                    ->schema([
                                        TextEntry::make('tea_or_coffee')
                                            ->placeholder('-')
                                            ->formatStateUsing(fn (string $state) => ucwords($state)),

                                        TextEntry::make('beer_wine_or_spirits')
                                            ->placeholder('-')
                                            ->formatStateUsing(fn (string $state) => ucwords($state)),

                                        TextEntry::make('sweet_or_salty')
                                            ->placeholder('-')
                                            ->formatStateUsing(fn (string $state) => ucwords($state)),

                                        TextEntry::make('brights_or_neutrals')
                                            ->placeholder('-')
                                            ->formatStateUsing(fn (string $state) => ucwords($state)),
                                    ]),
                            ]),

                        TextEntry::make('id_really_want')
                            ->label("They'd really like to receive...")
                            ->placeholder('-'),

                        TextEntry::make('please_avoid')
                            ->label('Please avoid giving them...')
                            ->placeholder('-'),

                        TextEntry::make('allergies')
                            ->label('Allergies / Dietary restrictions')
                            ->columnSpanFull()
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
