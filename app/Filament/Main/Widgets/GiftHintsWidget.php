<?php

namespace App\Filament\Main\Widgets;

use App\Enums\GiftPreference;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
                        TextInput::make('foods'),
                        TextInput::make('drinks'),
                        TextInput::make('snacks'),
                        TextInput::make('candies'),
                        TextInput::make('restaurants'),
                        TextInput::make('colors'),
                        TextInput::make('scents'),
                        TextInput::make('sports'),
                        TextInput::make('stores'),
                        TextInput::make('books'),
                        TextInput::make('music'),
                        TextInput::make('hobbies'),
                    ]),

                Group::make()
                    ->schema([
                        Fieldset::make('Preferences')
                            ->columns(1)
                            ->schema([
                                CheckboxList::make('preferences')
                                    ->hiddenLabel()
                                    ->options(GiftPreference::class)
                                    ->columns(3),
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

                                ToggleButtons::make('colors')
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

                TextInput::make('allergies')
                    ->label('Allergies / Dietary restrictions')
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();

        auth()->user()->giftHints()->updateOrCreate(
            [],
            $data,
        );

        Notification::make()
            ->title('Gift hints saved successfully.')
            ->body('Your Secret Santa will be happy!')
            ->success()
            ->send();
    }
}
