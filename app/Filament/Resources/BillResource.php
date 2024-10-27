<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BillResource\Pages;
use App\Filament\Resources\BillResource\RelationManagers;
use App\Models\Bill;
use Faker\Core\Number;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Date;

class BillResource extends Resource
{
    protected static ?string $model = Bill::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-euro';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('client_id')
                    ->label('Client')
                    ->relationship('client', 'name')
                    ->required(),
                TextInput::make('number')
                    ->label('Bill number')
                    ->required(),
                DatePicker::make('date')
                    ->label('Date')
                    ->required(),
                DatePicker::make('due_date')
                    ->label('Due date')
                    ->required(),
                Select::make('currency')
                    ->label('Currency')
                    ->options([
                        'USD' => 'USD',
                        'EUR' => 'EUR',
                        'GBP' => 'GBP',
                    ])
                    ->required(),
                TextInput::make('amount')
                    ->label('Amount')
                    ->integer()
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'sent' => 'Sent',
                        'paid' => 'Paid',
                    ])
                    ->required(),
                TextArea::make('notes')
                    ->label('Notes')
                    ->nullable()
                    ->rows(1),
                Textarea::make('items')
                    ->label('Items')
                    ->nullable()
                    ->columnSpan(2)
                    ->rows(5)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->label('Bill number')
                    ->sortable(),
                TextColumn::make('client.name')
                    ->label('Client')
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Date')
                    ->sortable(),
                TextColumn::make('due_date')
                    ->label('Due date')
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->sortable()
                    ->formatStateUsing(fn ($state, $record) => $state . ' ' . $record->currency),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'draft' => '<span style="background-color: rgba(128, 128, 128, 0.3); color: gray; border: 1px solid gray; padding: 4px 8px; border-radius: 4px;">' . ucfirst($state) . '</span>',
                            'sent' => '<span style="background-color: rgb(253, 218, 13, 0.3); color: rgb(253, 218, 13); border: 1px solid rgb(253, 218, 13); padding: 4px 8px; border-radius: 4px;">' . ucfirst($state) . '</span>',
                            'paid' => '<span style="background-color: rgb(34, 139, 34, 0.3); color: rgb(34, 139, 34); border: 1px solid rgb(34, 139, 34); padding: 4px 8px; border-radius: 4px;">' . ucfirst($state) . '</span>',
                            default => '<span style="background-color: rgba(255, 0, 0, 0.3); color: red; border: 1px solid red; padding: 4px 8px; border-radius: 4px;">Unknown</span>',
                        };
                    })
                    ->html(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'sent' => 'Sent',
                        'paid' => 'Paid',
                    ]),
                Filter::make('amount')
                    ->label('Price Range')
                    ->min(0)
                    ->max(10000)
                    ->step(100)
                    ->default([0, 10000])
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $set('filters.amount', $state);
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('')
                    ->icon('heroicon-o-eye')
                    ->color('white'),
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary'),
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
            'index' => Pages\ListBills::route('/'),
            'create' => Pages\CreateBill::route('/create'),
            'edit' => Pages\EditBill::route('/{record}/edit'),
        ];
    }
}
