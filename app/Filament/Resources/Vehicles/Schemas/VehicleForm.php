<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('customer_id')
                    ->relationship('customer', 'id')
                    ->required(),
                Select::make('vehicle_make_id')
                    ->relationship('vehicleMake', 'name')
                    ->required(),
                Select::make('vehicle_model_id')
                    ->relationship('vehicleModel', 'name')
                    ->required(),
                Select::make('fuel_type_id')
                    ->relationship('fuelType', 'name')
                    ->required(),
                TextInput::make('number_plate')
                    ->required(),
                TextInput::make('number_of_gears')
                    ->numeric(),
                TextInput::make('year_of_manufacturing')
                    ->numeric(),
                TextInput::make('odometer_reading')
                    ->numeric(),
                TextInput::make('gearbox_number'),
                TextInput::make('engine_number'),
                TextInput::make('chassis_number'),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}
