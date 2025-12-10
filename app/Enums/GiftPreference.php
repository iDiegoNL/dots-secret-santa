<?php

namespace App\Enums;

use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum GiftPreference: string implements HasDescription, HasIcon, HasLabel
{
    case GiftCards = 'gift_cards';
    case HomeDecor = 'home_decor';
    case Stationery = 'stationery';
    case Plants = 'plants';
    case Socks = 'socks';
    case MovieTickets = 'movie_tickets';
    case GamesPuzzles = 'games_puzzles';
    case BathProducts = 'bath_products';
    case ChocolateSweets = 'chocolate_sweets';
    case Alcohol = 'alcohol';
    case Books = 'books';
    case Dice = 'dice';

    public function getLabel(): string
    {
        return match ($this) {
            self::GiftCards => 'Gift Cards',
            self::HomeDecor => 'Home Decor',
            self::Stationery => 'Stationery',
            self::Plants => 'Plants',
            self::Socks => 'Socks',
            self::MovieTickets => 'Movie Tickets',
            self::GamesPuzzles => 'Games & Puzzles',
            self::BathProducts => 'Bath Products',
            self::ChocolateSweets => 'Chocolate & Sweets',
            self::Alcohol => 'Alcohol',
            self::Books => 'Books',
            self::Dice => 'Dice',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::GiftCards => 'tabler-gift-card',
            self::HomeDecor => 'tabler-lamp',
            self::Stationery => 'tabler-writing',
            self::Plants => 'tabler-plant',
            self::Socks => 'tabler-sock',
            self::MovieTickets => 'tabler-ticket',
            self::GamesPuzzles => 'tabler-puzzle',
            self::BathProducts => 'tabler-bath',
            self::ChocolateSweets => 'tabler-candy',
            self::Alcohol => 'tabler-glass-cocktail',
            self::Books => 'tabler-book',
            self::Dice => 'tabler-dice-6',
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Stationery => 'E.g. notebooks, pens',
            default => null,
        };
    }

    public static function tryFromLabel(string $label): ?GiftPreference
    {
        foreach (self::cases() as $case) {
            if ($case->getLabel() === $label) {
                return $case;
            }
        }

        return null;
    }
}
