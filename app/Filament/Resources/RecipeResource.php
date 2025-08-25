<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecipeResource\Pages;
use App\Models\Recipe;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class RecipeResource extends Resource
{
    protected static ?string $model = Recipe::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('food_id')
                    ->relationship('food', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Grid::make(1)
                    ->schema([
                        Forms\Components\Repeater::make('ingredients')
                            ->schema([
                                Forms\Components\TextInput::make('ingredient')
                                    ->label('Bahan')
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->collapsible()
                            ->itemLabel(fn(array $state): ?string => $state['ingredient'] ?? null)
                            ->addActionLabel('Tambah Bahan'),

                        Forms\Components\Repeater::make('instructions')
                            ->schema([
                                Forms\Components\Textarea::make('step')
                                    ->label('Langkah')
                                    ->required()
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])
                            ->collapsible()
                            // Menggunakan Str::limit() agar lebih bersih dan aman
                            ->itemLabel(fn(array $state): ?string => Str::limit($state['step'] ?? '', 50))
                            ->addActionLabel('Tambah Langkah'),
                    ]),

                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\TextInput::make('prep_time')
                            ->label('Prep Time (minutes)')
                            ->numeric()
                            ->minValue(0),

                        Forms\Components\TextInput::make('cook_time')
                            ->label('Cook Time (minutes)')
                            ->numeric()
                            ->minValue(0),

                        Forms\Components\TextInput::make('servings')
                            ->numeric()
                            ->minValue(1),
                    ]),

                Forms\Components\Select::make('difficulty')
                    ->options([
                        'easy' => 'Easy',
                        'medium' => 'Medium',
                        'hard' => 'Hard',
                    ]),

                Forms\Components\Toggle::make('is_active')
                    ->inline(false)
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('food.name')
                    ->label('Food')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('prep_time')
                    ->label('Prep Time')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('cook_time')
                    ->label('Cook Time')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('servings')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('difficulty')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'easy' => 'success',
                        'medium' => 'warning',
                        'hard' => 'danger',
                    }),

                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('difficulty')
                    ->options([
                        'easy' => 'Easy',
                        'medium' => 'Medium',
                        'hard' => 'Hard',
                    ]),

                Filter::make('is_active')->toggle(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecipes::route('/'),
            'create' => Pages\CreateRecipe::route('/create'),

            'edit' => Pages\EditRecipe::route('/{record}/edit'),
        ];
    }
}
