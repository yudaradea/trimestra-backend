<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FoodResource\Pages;
use App\Filament\Resources\FoodResource\RelationManagers;
use App\Filament\Resources\FoodResource\RelationManagers\RecipesRelationManager;
use App\Models\Food;
use App\Models\FoodCategory;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FoodResource extends Resource
{
    protected static ?string $model = Food::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),

                // Food Image Upload
                Forms\Components\FileUpload::make('image_path')
                    ->label('Food Image')
                    ->image()
                    ->directory('food_images')
                    ->visibility('public')
                    ->columnSpanFull(),

                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\TextInput::make('calories')
                            ->required()
                            ->numeric()
                            ->step(0.01),

                        Forms\Components\TextInput::make('protein')
                            ->required()
                            ->numeric()
                            ->step(0.01),

                        Forms\Components\TextInput::make('carbs')
                            ->required()
                            ->numeric()
                            ->step(0.01),

                        Forms\Components\TextInput::make('fat')
                            ->required()
                            ->numeric()
                            ->step(0.01),

                        Forms\Components\TextInput::make('fiber')
                            ->required()
                            ->numeric()
                            ->step(0.01),

                        Forms\Components\TextInput::make('serving_size')
                            ->required()
                            ->maxLength(50),

                        Forms\Components\TextInput::make('cooking_time')
                            ->numeric()
                            ->minValue(0),

                        Forms\Components\Toggle::make('is_pregnancy_safe')
                            ->label('Pregnancy Safe')
                            ->inline(false)

                            ->default(false),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->inline(false)
                            ->default(true),

                    ]),


                Forms\Components\TagsInput::make('allergens')
                    ->label('Allergens')
                    ->placeholder('Add allergen'),

                Forms\Components\TagsInput::make('diet_types')
                    ->label('Diet Types')
                    ->placeholder('Add diet type')
                    ->suggestions([
                        'normal',
                        'vegetarian',
                        'vegan',
                        'keto',
                        'paleo',
                        'gluten-free'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Image')
                    ->circular()
                    ->size(50),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),

                ToggleColumn::make('is_pregnancy_safe')
                    ->label('Pregnancy Safe')
                    ->sortable(),


                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),


                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),

            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            RecipesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFood::route('/'),
            'create' => Pages\CreateFood::route('/create'),
            'edit' => Pages\EditFood::route('/{record}/edit'),
        ];
    }
}
