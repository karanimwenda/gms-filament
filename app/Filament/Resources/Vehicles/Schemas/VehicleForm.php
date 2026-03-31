<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('customer_id')
                    ->relationship('customer', 'email')
                    ->searchable()
                    ->required()
                    ->columnSpanFull(),
                Select::make('vehicle_make_id')
                    ->live()
                    ->relationship('vehicleMake', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->afterStateUpdated(function (Set $set) {
                        $set('vehicle_model_id', '');
                    }),
                Select::make('vehicle_model_id')
                    ->relationship(
                        name: 'vehicleModel',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query, Get $get) => $query?->where('vehicle_make_id', '=', $get('vehicle_make_id') ?? -1)
                    )
                    ->searchable()
                    ->preload()
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
