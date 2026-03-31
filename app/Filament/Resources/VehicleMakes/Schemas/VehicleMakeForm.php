<?php

namespace App\Filament\Resources\VehicleMakes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VehicleMakeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
