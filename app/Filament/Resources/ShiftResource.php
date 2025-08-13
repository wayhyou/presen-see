<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShiftResource\Pages;
use App\Filament\Resources\ShiftResource\RelationManagers;
use App\Models\Shift;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShiftResource extends Resource
{
    protected static ?string $model = Shift::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Shift Name')
                    ->autofocus()
                    ->autocapitalize()
                    ->placeholder('Enter Shift Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('start_time')
                    ->label('Start Time')
                    ->required()
                    ->mask('99:99')
                    ->placeholder('08:00')
                    ->helperText('Format: HH:mm (24 jam)')
                    ->formatStateUsing(fn ($state) => $state . ':00'),

                Forms\Components\TextInput::make('end_time')
                    ->label('Start Time')
                    ->required()
                    ->mask('99:99')
                    ->placeholder('17:00')
                    ->helperText('Format: HH:mm (24 jam)')
                    ->formatStateUsing(fn ($state) => $state . ':00'),

                Forms\Components\TextInput::make('break_minutes')
                    ->label('Break Minutes')
                    ->numeric()
                    ->default(0)
                    ->minValue(0),

            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Shift Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Start Time')
                    ->time('H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->label('End Time')
                    ->time('H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('break_minutes')
                    ->label('Break Minutes')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListShifts::route('/'),
            'create' => Pages\CreateShift::route('/create'),
            'edit' => Pages\EditShift::route('/{record}/edit'),
        ];
    }
}
