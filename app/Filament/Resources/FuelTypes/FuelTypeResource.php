<?php

namespace App\Filament\Resources\FuelTypes;

use App\Filament\Resources\FuelTypes\Pages\CreateFuelType;
use App\Filament\Resources\FuelTypes\Pages\EditFuelType;
use App\Filament\Resources\FuelTypes\Pages\ListFuelTypes;
use App\Filament\Resources\FuelTypes\Schemas\FuelTypeForm;
use App\Filament\Resources\FuelTypes\Tables\FuelTypesTable;
use App\Models\FuelType;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class FuelTypeResource extends Resource
{
    protected static ?string $model = FuelType::class;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    public static function form(Schema $schema): Schema
    {
        return FuelTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FuelTypesTable::configure($table);
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
            'index' => ListFuelTypes::route('/'),
            'create' => CreateFuelType::route('/create'),
            'edit' => EditFuelType::route('/{record}/edit'),
        ];
    }
}
