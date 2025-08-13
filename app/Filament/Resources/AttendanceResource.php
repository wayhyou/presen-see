<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Attendance;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Attendance Info')
                    ->columns(2)
                    ->schema([
                        Select::make('employee_id')
                            ->label('Employee')
                            ->relationship('employee', 'id')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->user->name ?? 'Unknown')
                            ->required()
                            ->searchable()
                            ->preload(),

                        DatePicker::make('date')
                            ->label('Date')
                            ->required(),

                        TimePicker::make('check_in')
                            ->label('Check In')
                            ->required()
                            ->displayFormat('HH:mm')
                            ->format('H:i:s'),

                        TimePicker::make('check_out')
                            ->label('Check Out')
                            ->displayFormat('HH:mm')
                            ->format('H:i:s'),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'present' => 'Present',
                                'late' => 'Late',
                                'early_leave' => 'Early Leave',
                                'absent' => 'Absent',
                            ])
                            ->default('present'),
                    ]),

                Section::make('Location Info')
                    ->columns(2)
                    ->schema([
                        TextInput::make('check_in_latitude')
                            ->label('Check In Latitude')
                            ->numeric()
                            ->step(0.0000001)
                            ->nullable(),

                        TextInput::make('check_in_longitude')
                            ->label('Check In Longitude')
                            ->numeric()
                            ->step(0.0000001)
                            ->nullable(),

                        TextInput::make('check_out_latitude')
                            ->label('Check Out Latitude')
                            ->numeric()
                            ->step(0.0000001)
                            ->nullable(),

                        TextInput::make('check_out_longitude')
                            ->label('Check Out Longitude')
                            ->numeric()
                            ->step(0.0000001)
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.user.name')
                    ->label('Employee')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('employee.shift.name')
                    ->label('Shift')
                    ->formatStateUsing(fn ($state, $record) =>
                        $state . '<br>' .
                        \Carbon\Carbon::createFromFormat('H:i:s', $record->employee->shift->start_time)->format('H:i') . ' - ' .
                        \Carbon\Carbon::createFromFormat('H:i:s', $record->employee->shift->end_time)->format('H:i')
                    )
                    ->html()
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Date')
                    ->date()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('check_in')
                    ->label('Check In')
                    ->time()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('check_out')
                    ->label('Check Out')
                    ->time()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'present' => 'Present',
                        'late' => 'Late',
                        'early_leave' => 'Early Leave',
                        'absent' => 'Absent',
                        default => 'Unknown',
                    })
                    ->sortable()
                    ->searchable(),
            ])->defaultSort('date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('employee_id')
                    ->label('Employee')
                    ->relationship(
                        name: 'employee',
                        titleAttribute: 'id',
                        modifyQueryUsing: fn ($query) => $query->with('user')->orderBy(User::select('name')->whereColumn('users.id', 'employees.user_id'))
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->user->name ?? 'Unknown')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'present' => 'Present',
                        'late' => 'Late',
                        'early_leave' => 'Early Leave',
                        'absent' => 'Absent',
                    ])
                    ->label('Status'),
                Tables\Filters\Filter::make('date_range')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('date', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('date', '<=', $data['until']));
                    }),
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
