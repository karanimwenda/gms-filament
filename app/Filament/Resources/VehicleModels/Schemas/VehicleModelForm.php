<?php

namespace App\Filament\Resources\VehicleModels\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VehicleModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('vehicle_make_id')
                    ->relationship('vehicleMake', 'name')
                    ->required(),
            ]);
    }
}
