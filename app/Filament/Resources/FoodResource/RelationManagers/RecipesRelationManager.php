<?php

namespace App\Filament\Resources\FoodResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RecipesRelationManager extends RelationManager
{
    protected static string $relationship = 'recipes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Grid::make(1)
                    ->schema([
                        Forms\Components\Repeater::make('ingredients')
                            ->schema([
                                Forms\Components\TextInput::make('ingredient')
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->collapsible()
                            ->itemLabel(fn(array $state): ?string => $state['ingredient'] ?? null)
                            ->addActionLabel('Tambah Bahan'),

                        Forms\Components\Repeater::make('instructions')
                            ->schema([
                                Forms\Components\Textarea::make('step')
                                    ->required()
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])
                            ->collapsible()
                            ->itemLabel(fn(array $state): ?string => substr($state['step'] ?? '', 0, 50) . '...' ?? null)
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

                Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('difficulty')
                            ->options([
                                'easy' => 'Easy',
                                'medium' => 'Medium',
                                'hard' => 'Hard',
                            ]),

                        Forms\Components\Toggle::make('is_active')
                            ->inline(false)
                            ->default(true),
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
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

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])

            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
