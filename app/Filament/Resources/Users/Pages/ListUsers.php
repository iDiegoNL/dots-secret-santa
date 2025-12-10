<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Grid;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),

            Action::make('bulkCreate')
                ->model(User::class)
                ->schema([
                    TextArea::make('binary_names')
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $binaryNames = preg_split('/\r\n|\r|\n/', $data['binary_names']);
                    foreach ($binaryNames as $binaryName) {
                        User::create([
                            'name' => trim($binaryName),
                        ]);
                    }
                }),

            Action::make('assignSecretSanta')
                ->model(User::class)
                ->schema([
                    Grid::make()
                        ->schema([
                            Select::make('gifter')
                                ->label('Choose gifter')
                                ->relationship(
                                    name: 'givingTo',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn (Builder $query) => $query
                                        ->where('is_participating', true)
                                        ->doesntHave('givingTo')
                                )
                                ->getOptionLabelFromRecordUsing(fn (User $record) => $record->decoded_name)
                                ->preload()
                                ->optionsLimit(999)
                                ->required()
                                ->different('recipient'),

                            Select::make('recipient')
                                ->label('Choose recipient')
                                ->relationship(
                                    name: 'receivingFrom',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn (Builder $query) => $query
                                        ->where('is_participating', true)
                                        ->doesntHave('receivingFrom')
                                )
                                ->searchable()
                                ->preload()
                                ->optionsLimit(999)
                                ->required()
                                ->different('gifter'),
                        ]),
                ])
                ->action(function (array $data): void {
                    $gifter = User::findOrFail($data['gifter']);
                    $recipient = User::findOrFail($data['recipient']);

                    $gifter->givingTo()->associate($recipient);
                    $gifter->save();
                }),

            Action::make('assignLeftovers')
                ->model(User::class)
                ->action(function (): void {
                    $usersWithoutRecipients = User::query()
                        ->where('is_participating', true)
                        ->doesntHave('givingTo')
                        ->get()
                        ->shuffle();

                    $recipients = User::query()
                        ->where('is_participating', true)
                        ->doesntHave('receivingFrom')
                        ->get()
                        ->shuffle();

                    foreach ($usersWithoutRecipients as $user) {
                        foreach ($recipients as $key => $recipient) {
                            if ($user->id !== $recipient->id) {
                                $user->givingTo()->associate($recipient);
                                $user->save();
                                $recipients->forget($key);
                                break;
                            }
                        }
                    }
                })
                ->requiresConfirmation(),

            Action::make('assignLoginCodes')
                ->action(function (): void {
                    User::query()
                        ->whereNull('login_code')
                        ->each(function (User $user) {
                            $user->generateLoginCode();
                        });
                })
                ->requiresConfirmation(),
        ];
    }
}
