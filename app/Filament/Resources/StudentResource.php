<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Group;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('group_id')
                    ->label('Group')
                    ->options(
                        Group::query()->pluck('name', 'id')->toArray()
                    )
                    ->required(),
                Forms\Components\TextInput::make('full_name')
                    ->required(),
                Forms\Components\TextInput::make('age')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('gender')
                    ->options([
                        1 => "Male",
                        2 => "Female",
                    ])->required(),
                Forms\Components\FileUpload::make('high_school_diploma')
                    ->openable()
                    ->required(),
                Forms\Components\FileUpload::make('passport')
                    ->openable()

                    ->required(),
                Forms\Components\Select::make('ielts_score')
                    ->options([
                        'No IELTS' => 'No IELTS',
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '7',
                        '8' => '8',
                        '9' => '9'
                    ]),
                Forms\Components\FileUpload::make('IELTS')
                    ->label('IELTS Certificate')
                    ->openable(),
                Forms\Components\Textarea::make('motivation_letter')

            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('age')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Gender')
                    ->formatStateUsing(function ($state) {
                        return $state == 1 ? 'Male' : ($state == 2 ? 'Female' : 'unknown');
                    }),

                Tables\Columns\TextColumn::make('ielts_score'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //filter by group
                Tables\Filters\SelectFilter::make('group_id')
                    ->options(
                        Group::query()->pluck('name', 'id')->toArray()
                    )
                    ->label('Group')
                    ->placeholder('All Groups'),
                //filter by gender
                Tables\Filters\SelectFilter::make('gender')
                    ->options([
                        1 => "Male",
                        2 => "Female",
                    ]),

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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
