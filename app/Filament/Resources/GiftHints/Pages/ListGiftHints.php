<?php

namespace App\Filament\Resources\GiftHints\Pages;

use App\Filament\Resources\GiftHints\GiftHintResource;
use Filament\Resources\Pages\ListRecords;

class ListGiftHints extends ListRecords
{
    protected static string $resource = GiftHintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
