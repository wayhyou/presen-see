<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->disabled(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord)
                    ->required(),

                Forms\Components\Select::make('office_id')
                    ->relationship('office', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('shift_id')
                    ->relationship('shift', 'name')
                    ->searchable()
                    ->preload(),

                Forms\Components\TextInput::make('employee_code')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Select::make('position')
                    ->options([
                        'Staff' => 'Staff',
                        'Supervisor' => 'Supervisor',
                        'Manager' => 'Manager',
                        'HRD' => 'HRD',
                        'Operator' => 'Operator',
                    ])
                    ->native(false),

                Forms\Components\DatePicker::make('join_date')
                    ->default(now())
                    ->disabled(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('Nama')->sortable(),
                Tables\Columns\TextColumn::make('office.name')->label('Office')->sortable(),
                Tables\Columns\TextColumn::make('department.name')->label('Department')->sortable(),
                Tables\Columns\TextColumn::make('shift.name')->label('Shift')->sortable(),
                Tables\Columns\TextColumn::make('employee_code')->sortable(),
                Tables\Columns\TextColumn::make('position')->sortable(),
                Tables\Columns\TextColumn::make('join_date')->date()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('office_id')
                    ->label('Office')
                    ->relationship('office', 'name'),

                Tables\Filters\SelectFilter::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'name'),

                Tables\Filters\SelectFilter::make('shift_id')
                    ->label('Shift')
                    ->relationship('shift', 'name'),

                Tables\Filters\Filter::make('no_position')
                    ->label('No Position')
                    ->query(fn ($query) => $query->whereNull('position')->orWhere('position', '')),

                Tables\Filters\Filter::make('no_office')
                    ->label('No Office')
                    ->query(fn ($query) => $query->whereNull('office_id')),

                Tables\Filters\Filter::make('no_department')
                    ->label('No Department')
                    ->query(fn ($query) => $query->whereNull('department_id')),

                Tables\Filters\Filter::make('no_shift')
                    ->label('No Shift')
                    ->query(fn ($query) => $query->whereNull('shift_id')),

                Tables\Filters\Filter::make('joined_this_year')
                    ->label('Joined This Year')
                    ->query(fn ($query) => $query->whereYear('join_date', date('Y'))),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
