<?php

namespace App\Filament\Main\Widgets;

use App\Enums\GiftPreference;
use App\Models\GiftHint;
use App\Models\User;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
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
                                        RepeatableEntry::make('preferences')
                                            ->schema([
                                                TextEntry::make('name')
                                                    ->hiddenLabel()
                                                    ->icon(fn ($state) => GiftPreference::tryFromLabel($state)?->getIcon())
                                                    ->belowContent(fn ($state) => Text::make(GiftPreference::tryFromLabel($state)?->getDescription())->size(TextSize::ExtraSmall))
                                                    ->badge(),
                                            ])
                                            ->getStateUsing(function (?GiftHint $hint) {
                                                $preferences = $hint->preferences;

                                                // Map to array of arrays with 'name' key, and value of GiftPreference enum getLabel
                                                return collect($preferences)->map(function ($preference) {
                                                    $giftPreference = GiftPreference::tryFrom($preference);

                                                    return [
                                                        'name' => $giftPreference->getLabel() ?? Str::of($preference)->replace('_', ' ')->ucwords(),
                                                    ];
                                                })->toArray();
                                            })
                                            ->grid(3)
                                            ->contained(false),
                                    ]),

                                Fieldset::make('This or that')
                                    ->columns()
                                    ->schema([
                                        TextEntry::make('tea_or_coffee')
                                            ->placeholder('-')
                                            ->formatStateUsing(fn (string $state) => ucwords($state))
                                            ->badge()
                                            ->icon(fn (?string $state) => match ($state) {
                                                'tea' => 'tabler-leaf',
                                                'coffee' => 'tabler-coffee',
                                                default => null
                                            }),

                                        TextEntry::make('beer_wine_or_spirits')
                                            ->placeholder('-')
                                            ->formatStateUsing(fn (string $state) => ucwords($state))
                                            ->badge()
                                            ->icon(fn (?string $state) => match ($state) {
                                                'beer' => 'tabler-beer',
                                                'wine' => 'tabler-glass-full',
                                                'spirits' => 'tabler-glass-cocktail',
                                                default => null
                                            }),

                                        TextEntry::make('sweet_or_salty')
                                            ->placeholder('-')
                                            ->formatStateUsing(fn (string $state) => ucwords($state))
                                            ->badge()
                                            ->icon(fn (?string $state) => match ($state) {
                                                'sweet' => 'tabler-candy',
                                                'salty' => 'tabler-salt',
                                                default => null
                                            }),

                                        TextEntry::make('brights_or_neutrals')
                                            ->placeholder('-')
                                            ->formatStateUsing(fn (string $state) => ucwords($state))
                                            ->badge()
                                            ->icon(fn (?string $state) => match ($state) {
                                                'brights' => 'tabler-palette',
                                                'neutrals' => 'tabler-color-filter',
                                                default => null
                                            }),
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
