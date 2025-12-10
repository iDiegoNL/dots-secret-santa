<?php

namespace App\Filament\Main\Widgets;

use App\Enums\GiftPreference;
use App\Models\GiftHint;
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

    public ?GiftHint $giftHints = null;

    public function mount(): void
    {
        $this->giftHints = auth()->user()->giftHints;

        $this->form->fill($this->giftHints?->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->model($this->giftHints ?? GiftHint::class)
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
            ]);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        if (! $this->giftHints) {
            auth()->user()->giftHints()->create($data);
        } else {
            $this->giftHints->update($data);
        }

        Notification::make()
            ->title('Gift hints saved successfully.')
            ->body('Your Secret Santa will be happy!')
            ->success()
            ->send();
    }
}
