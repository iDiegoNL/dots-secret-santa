<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontFamily;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->helperText(fn (User $record) => $record->decoded_name),

                TextEntry::make('login_code')
                    ->placeholder('-')
                    ->fontFamily(FontFamily::Mono)
                    ->copyable()
                    ->hintAction(
                        Action::make('generateLoginCode')
                            ->icon('heroicon-o-arrow-path')
                            ->visible(fn (User $record) => $record->login_code === null)
                            ->action(function (User $record) {
                                $record->generateLoginCode();

                                Notification::make()
                                    ->title('Login code generated')
                                    ->success()
                                    ->send();
                            })
                    ),

                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
