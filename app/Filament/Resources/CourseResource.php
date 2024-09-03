<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Website';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    protected static ?string $navigationLabel = 'Courses';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Course Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Course Name')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('shortcut')
                            ->required()
                            ->label('Shortcut')
                            ->maxLength(50),

                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->label('Price')
                            ->numeric()
                            ->prefix('$'),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(5),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Course Image')
                            ->image()
                            ->directory('course-images')
                            ->required(),

                        Forms\Components\Toggle::make('status')
                            ->label('Active Status')
                            ->default(true),

                        Forms\Components\Toggle::make('trending')
                            ->label('Trending')
                            ->default(false),
                        // Hidden field for user_id
                        Forms\Components\Hidden::make('user_id')
                            ->default(fn() => Auth::id()), // Automatically sets the user_id to the authenticated user
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
