<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontFamily;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->inRandomOrder())
            ->paginated(false)
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('decoded_name')
                    ->label('Name (decoded)')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('login_code')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->fontFamily(FontFamily::Mono)
                    ->numeric(thousandsSeparator: ' ')
                    ->copyable(),

                IconColumn::make('is_participating')
                    ->label('Participating')
                    ->boolean()
                    ->sortable(),

                IconColumn::make('submitted_hints')
                    ->getStateUsing(fn (User $record) => $record->giftHints !== null)
                    ->boolean()
                    ->sortable(),

                TextColumn::make('givingTo.name')
                    ->label('Giving gift to')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('receivingFrom.name')
                    ->label('Receiving gift from')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

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
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
