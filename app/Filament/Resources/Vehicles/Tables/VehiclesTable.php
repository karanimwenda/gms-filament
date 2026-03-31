<?php

namespace App\Filament\Resources\Vehicles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VehiclesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.id')
                    ->searchable(),
                TextColumn::make('vehicleMake.name')
                    ->searchable(),
                TextColumn::make('vehicleModel.name')
                    ->searchable(),
                TextColumn::make('fuelType.name')
                    ->searchable(),
                TextColumn::make('number_plate')
                    ->searchable(),
                TextColumn::make('number_of_gears')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('year_of_manufacturing')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('odometer_reading')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('gearbox_number')
                    ->searchable(),
                TextColumn::make('engine_number')
                    ->searchable(),
                TextColumn::make('chassis_number')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
