<?php

namespace App\Filament\Resources\VehicleMakes;

use App\Filament\Resources\VehicleMakes\Pages\CreateVehicleMake;
use App\Filament\Resources\VehicleMakes\Pages\EditVehicleMake;
use App\Filament\Resources\VehicleMakes\Pages\ListVehicleMakes;
use App\Filament\Resources\VehicleMakes\Schemas\VehicleMakeForm;
use App\Filament\Resources\VehicleMakes\Tables\VehicleMakesTable;
use App\Models\VehicleMake;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class VehicleMakeResource extends Resource
{
    protected static ?string $model = VehicleMake::class;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    public static function form(Schema $schema): Schema
    {
        return VehicleMakeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VehicleMakesTable::configure($table);
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
            'index' => ListVehicleMakes::route('/'),
            'create' => CreateVehicleMake::route('/create'),
            'edit' => EditVehicleMake::route('/{record}/edit'),
        ];
    }
}
