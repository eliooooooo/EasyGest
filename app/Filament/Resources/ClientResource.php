<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->placeholder('John Doe')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->placeholder('john.doe@mail.com')
                    ->email()
                    ->nullable(),
                TextInput::make('phone')
                    ->label('Phone')
                    ->placeholder('00 00 00 00 00')
                    ->tel()
                    ->nullable(),
                TextInput::make('address')
                    ->label('Address')
                    ->placeholder('3 rue de la Paix')
                    ->nullable(),
                TextInput::make('city')
                    ->label('City')
                    ->placeholder('Paris')
                    ->nullable(),
                TextInput::make('zip')
                    ->label('Zip')
                    ->placeholder('75000')
                    ->nullable()
                    ->mask('99999'),
                TextInput::make('country')
                    ->label('Country')
                    ->placeholder('France')
                    ->nullable(),
                TextInput::make('owner')
                    ->label('Owner')
                    ->placeholder('John Doe')
                    ->nullable(),
                Textarea::make('notes')
                    ->label('Notes')
                    ->placeholder('Write some notes here...')
                    ->nullable()
                    ->columnSpan(2)
                    ->rows(5)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('owner')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
