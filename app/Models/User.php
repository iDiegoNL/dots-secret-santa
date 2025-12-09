<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use InvalidArgumentException;

class User extends Authenticatable implements FilamentUser, HasName
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use Notifiable;

    protected static function booted(): void
    {
        static::saving(function ($user) {
            if ($user->secret_santa_id && $user->secret_santa_id === $user->id) {
                throw new InvalidArgumentException('User cannot be their own secret santa.');
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'secret_santa_id',
        'is_admin',
        'is_participating',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_participating' => 'boolean',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function getDecodedNameAttribute(): string
    {
        return decode_binary($this->name);
    }

    public function givingTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'secret_santa_id');
    }

    public function receivingFrom(): HasOne
    {
        return $this->hasOne(User::class, 'secret_santa_id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin;
    }

    public function getFilamentName(): string
    {
        return $this->decoded_name;
    }

    public function getRouteKeyName(): string
    {
        return 'name';
    }

    public function giftHints(): HasOne
    {
        return $this->hasOne(GiftHint::class);
    }
}
