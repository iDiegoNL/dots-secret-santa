<?php

namespace App\Filament\Main\Pages;

use App\Filament\Main\Widgets\GiftHintsWidget;
use App\Filament\Main\Widgets\GivingToWidget;
use Filament\Pages\Page;

class Homepage extends Page
{
    protected string $view = 'filament.main.pages.homepage';

    protected static ?string $title = "🧑‍🎄 Dot's Secret Santa";

    protected static ?string $slug = '/';

    protected function getHeaderWidgets(): array
    {
        return [
            GivingToWidget::make([
                'givingTo' => auth()->user()->givingTo,
            ]),

            GiftHintsWidget::make(),
        ];
    }

    public function getHeaderWidgetsColumns(): int
    {
        return 1;
    }
}
