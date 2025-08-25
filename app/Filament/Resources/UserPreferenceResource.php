<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserPreferenceResource\Pages;
use App\Models\UserFoodPreference;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;

class UserPreferenceResource extends Resource
{
    protected static ?string $model = UserFoodPreference::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'User Preference';
    protected static ?string $pluralModelLabel = 'User Preferences';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('diet_type')
                    ->options([
                        'vegetarian' => 'Vegetarian',
                        'keto' => 'Keto',
                        'vegan' => 'Vegan',
                        'paleo' => 'Paleo',
                        'gluten-free' => 'Gluten Free',
                        'no_preference' => 'No Preference',
                    ])
                    ->required(),

                Forms\Components\CheckboxList::make('allergies')
                    ->options([
                        'telur' => 'Telur',
                        'susu' => 'Susu',
                        'kacang-kacangan' => 'Kacang-kacangan',
                        'ikan' => 'Ikan',
                        'udang' => 'Udang',
                        'gluten' => 'Gluten',
                        'kedelai' => 'Kedelai',
                        'tidak ada' => 'Tidak Ada',
                    ])
                    ->columns(2),

                Forms\Components\CheckboxList::make('preferred_meal_times')
                    ->options([
                        'breakfast' => 'Breakfast',
                        'lunch' => 'Lunch',
                        'dinner' => 'Dinner',
                        'snack' => 'Snack',
                    ])
                    ->columns(2),

                Forms\Components\Select::make('calorie_target')
                    ->options([
                        '<1500' => 'Less than 1500 calories',
                        '1500-2000' => '1500-2000 calories',
                        '>2000' => 'More than 2000 calories',
                        'not_sure' => 'Not Sure',
                    ])
                    ->required(),

                Forms\Components\Select::make('cooking_time_preference')
                    ->options([
                        '<15' => 'Less than 15 minutes',
                        '15-30' => '15-30 minutes',
                        '>30' => 'More than 30 minutes',
                    ])
                    ->required(),

                Forms\Components\Select::make('serving_preference')
                    ->options([
                        '3' => '3 servings',
                        '4' => '4 servings',
                        '5' => '5 servings',
                        '>5' => 'More than 5 servings',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('diet_type')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('calorie_target')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('cooking_time_preference')
                    ->label('Cooking Time')
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('diet_type')
                    ->options([
                        'vegetarian' => 'Vegetarian',
                        'keto' => 'Keto',
                        'vegan' => 'Vegan',
                        'paleo' => 'Paleo',
                        'gluten-free' => 'Gluten Free',
                        'no_preference' => 'No Preference',
                    ]),

                Tables\Filters\SelectFilter::make('calorie_target')
                    ->options([
                        '<1500' => 'Less than 1500',
                        '1500-2000' => '1500-2000',
                        '>2000' => 'More than 2000',
                        'not_sure' => 'Not Sure',
                    ]),
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
            'index' => Pages\ListUserPreferences::route('/'),
            'create' => Pages\CreateUserPreference::route('/create'),
            'edit' => Pages\EditUserPreference::route('/{record}/edit'),
        ];
    }
}
