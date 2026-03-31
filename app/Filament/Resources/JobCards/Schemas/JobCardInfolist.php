<?php

namespace App\Filament\Resources\JobCards\Schemas;

use App\Models\JobCard;
use App\Models\JobCardItem;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;

class JobCardInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Base Information')
                    ->description('Base information about the job card')
                    ->columnSpanFull()
                    ->collapsible()
                    ->columns([
                        'md' => 2,
                        'xl' => 4,
                    ])
                    ->schema([
                        Fieldset::make('Customer')
                            ->columnSpan(2)
                            ->schema([
                                TextEntry::make('customer.first_name')
                                    ->label('First Name'),
                                TextEntry::make('customer.last_name')
                                    ->label('Last Name'),
                                TextEntry::make('customer.email')
                                    ->icon(Heroicon::Envelope)
                                    ->label('Email'),
                                TextEntry::make('customer.phone_number')
                                    ->icon(Heroicon::Phone)
                                    ->label('Phone Number'),
                            ]),
                        Fieldset::make('Vehicle')
                            ->columnSpan(2)
                            ->columns(3)
                            ->schema([
                                TextEntry::make('vehicle.number_plate')
                                    ->label('Number Plate'),
                                TextEntry::make('vehicle.engine_number')
                                    ->label('Engine Number'),
                                TextEntry::make('vehicle.chassis_number')
                                    ->label('Chassis Number'),
                                TextEntry::make('vehicle.id')
                                    ->label('Make & Model')
                                    ->formatStateUsing(fn (JobCard $record) => "{$record->vehicle->vehicleMake?->name} {$record->vehicle->vehicleModel?->name}"),
                                TextEntry::make('vehicle.fuelType.name')
                                    ->label('Fuel Type'),
                                TextEntry::make('vehicle.odometer_reading')
                                    ->numeric()
                                    ->label('Odometer Reading'),
                            ]),
                        TextEntry::make('status')
                            ->badge()
                            ->columnSpan(2)
                            ->helperText(fn (JobCard $record) => $record->status->getDescription()),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('notes')
                            ->placeholder('-')
                            ->columnSpan(2),
                    ]),

                RepeatableEntry::make('jobCardItems')
                    ->columnSpanFull()
                    ->columns(4)
                    ->schema([
                        TextEntry::make('service.name')
                            ->columnSpan(2)
                            ->hidden(fn (JobCardItem $record) => blank($record->service_id)),
                        TextEntry::make('part.name')
                            ->columnSpan(2)
                            ->hidden(fn (JobCardItem $record) => blank($record->part_id)),
                        TextEntry::make('type')
                            ->columnSpan(2)
                            ->badge()
                            ->color('gray'),
                        TextEntry::make('employee.id')
                            ->label('Employee')
                            ->formatStateUsing(fn (JobCardItem $record) => "{$record->employee->first_name} {$record->employee->last_name}")
                            ->placeholder('-'),
                        TextEntry::make('quantity')
                            ->numeric(),
                        TextEntry::make('selling_price')
                            ->label('Selling Price (KSH)')
                            ->numeric(),
                        TextEntry::make('sub_total')
                            ->label('Sub Total (KSH)')
                            ->numeric(),
                    ]),

                Flex::make([
                    Section::make()
                        ->grow(false)
                        ->schema([
                            TextEntry::make('total')
                                ->money('KSH')
                                ->inlineLabel()
                                ->size(TextSize::Large),
                        ]),
                ])->columnSpanFull()->alignEnd(),
            ]);
    }
}
