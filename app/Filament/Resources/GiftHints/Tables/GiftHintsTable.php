<?php

namespace App\Filament\Resources\GiftHints\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GiftHintsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.decoded_name')
                    ->searchable(),
                TextColumn::make('foods')
                    ->searchable(),
                TextColumn::make('drinks')
                    ->searchable(),
                TextColumn::make('snacks')
                    ->searchable(),
                TextColumn::make('candies')
                    ->searchable(),
                TextColumn::make('restaurants')
                    ->searchable(),
                TextColumn::make('colors')
                    ->searchable(),
                TextColumn::make('scents')
                    ->searchable(),
                TextColumn::make('sports')
                    ->searchable(),
                TextColumn::make('stores')
                    ->searchable(),
                TextColumn::make('books')
                    ->searchable(),
                TextColumn::make('music')
                    ->searchable(),
                TextColumn::make('hobbies')
                    ->searchable(),
                TextColumn::make('tea_or_coffee')
                    ->searchable(),
                TextColumn::make('beer_wine_or_spirits')
                    ->searchable(),
                TextColumn::make('sweet_or_salty')
                    ->searchable(),
                TextColumn::make('allergies')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
