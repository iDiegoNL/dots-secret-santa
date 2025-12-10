<?php

namespace App\Filament\Resources\GiftHints;

use App\Filament\Resources\GiftHints\Pages\ListGiftHints;
use App\Filament\Resources\GiftHints\Tables\GiftHintsTable;
use App\Models\GiftHint;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GiftHintResource extends Resource
{
    protected static ?string $model = GiftHint::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGift;

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'id';

    public static function table(Table $table): Table
    {
        return GiftHintsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGiftHints::route('/'),
        ];
    }
}
