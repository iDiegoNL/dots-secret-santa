<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum GiftPreference: string implements HasLabel
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
            self::Stationery => 'Stationery (e.g., notebooks, pens)',
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
}
