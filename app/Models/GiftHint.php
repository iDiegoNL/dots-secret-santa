<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiftHint extends Model
{
    protected $fillable = [
        'user_id',
        'foods',
        'drinks',
        'snacks',
        'candies',
        'restaurants',
        'colors',
        'scents',
        'sports',
        'stores',
        'books',
        'music',
        'hobbies',
        'preferences',
        'tea_or_coffee',
        'beer_wine_or_spirits',
        'sweet_or_salty',
        'id_really_want',
        'please_avoid',
        'allergies',
        'brights_or_neutrals',
    ];

    protected function casts(): array
    {
        return [
            'preferences' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
