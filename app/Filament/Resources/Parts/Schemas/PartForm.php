<?php

namespace App\Filament\Resources\Parts\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PartForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->columnSpanFull()
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('buying_price')
                    ->required()
                    ->numeric()
                    ->prefix('KSH'),
                TextInput::make('selling_price')
                    ->required()
                    ->numeric()
                    ->prefix('KSH'),
                TextInput::make('quantity_in_stock')
                    ->required()
                    ->numeric()
                    ->columnSpanFull(),
            ]);
    }
}
