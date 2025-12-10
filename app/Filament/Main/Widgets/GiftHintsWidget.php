<?php

namespace App\Filament\Main\Widgets;

use App\Enums\GiftPreference;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;

class GiftHintsWidget extends Widget implements HasSchemas
{
    use InteractsWithSchemas;

    protected string $view = 'filament.main.widgets.gift-hints-widget';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(auth()->user()->giftHints?->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns()
            ->components([
                Fieldset::make('Favourites')
                    ->columns()
                    ->schema([
                        Textarea::make('foods')
                            ->maxLength(255),

                        Textarea::make('drinks')
                            ->maxLength(255),

                        Textarea::make('snacks')
                            ->maxLength(255),

                        Textarea::make('candies')
                            ->maxLength(255),

                        Textarea::make('restaurants')
                            ->maxLength(255),

                        Textarea::make('colors')
                            ->maxLength(255),

                        Textarea::make('scents')
                            ->maxLength(255),

                        Textarea::make('sports')
                            ->maxLength(255),

                        Textarea::make('stores')
                            ->maxLength(255),

                        Textarea::make('books')
                            ->maxLength(255),

                        Textarea::make('music')
                            ->maxLength(255),

                        Textarea::make('hobbies')
                            ->maxLength(255),
                    ]),

                Group::make()
                    ->schema([
                        Fieldset::make('Preferences')
                            ->columns(1)
                            ->schema([
                                CheckboxList::make('preferences')
                                    ->hiddenLabel()
                                    ->options(collect(GiftPreference::cases())->mapWithKeys(function ($case) {
                                        return [$case->value => $case->getLabel()];
                                    })->toArray())
                                    ->columns(3)
                                    ->dehydrateStateUsing(function ($state) {
                                        if (empty($state)) {
                                            return [];
                                        }
                                        if (!is_array($state)) {
                                            return $state;
                                        }
                                        return array_values(array_map(function ($preference) {
                                            if ($preference instanceof GiftPreference) {
                                                return $preference->value;
                                            }
                                            return (string) $preference;
                                        }, $state));
                                    })
                                    ->afterStateHydrated(function ($component, $state) {
                                        // Ensure state is always an array
                                        if ($state === null) {
                                            $component->state([]);
                                        } elseif (!is_array($state)) {
                                            $component->state([$state]);
                                        }
                                    }),
                            ]),

                        Fieldset::make('This or that')
                            ->columns()
                            ->schema([
                                ToggleButtons::make('tea_or_coffee')
                                    ->inline()
                                    ->options([
                                        'tea' => 'Tea',
                                        'coffee' => 'Coffee',
                                    ]),

                                ToggleButtons::make('beer_wine_or_spirits')
                                    ->label('Beer, wine or spirits')
                                    ->inline()
                                    ->options([
                                        'beer' => 'Beer',
                                        'wine' => 'Wine',
                                        'spirits' => 'Spirits',
                                    ]),

                                ToggleButtons::make('sweet_or_salty')
                                    ->inline()
                                    ->options([
                                        'sweet' => 'Sweet',
                                        'salty' => 'Salty',
                                    ]),

                                ToggleButtons::make('brights_or_neutrals')
                                    ->inline()
                                    ->options([
                                        'brights' => 'Brights',
                                        'neutrals' => 'Neutrals',
                                    ]),
                            ]),
                    ]),

                Textarea::make('id_really_want')
                    ->label("I'd really like to receive...")
                    ->rows(3),

                Textarea::make('please_avoid')
                    ->label('Please avoid giving me...')
                    ->rows(3),

                Textarea::make('allergies')
                    ->label('Allergies / Dietary restrictions')
                    ->maxLength(255)
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();

        // Ensure preferences array contains string values, not enum instances
        if (isset($data['preferences']) && is_array($data['preferences'])) {
            $data['preferences'] = array_values(array_filter(array_map(function ($preference) {
                if ($preference instanceof GiftPreference) {
                    return $preference->value;
                }
                return (string) $preference;
            }, $data['preferences'])));
        } else {
            $data['preferences'] = [];
        }

        // Use updateOrCreate with explicit where clause
        auth()->user()->giftHints()->updateOrCreate(
            ['user_id' => auth()->id()],
            $data,
        );

        Notification::make()
            ->title('Gift hints saved successfully.')
            ->body('Your Secret Santa will be happy!')
            ->success()
            ->send();
    }
}
