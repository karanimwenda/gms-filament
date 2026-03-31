<?php

namespace App\Filament\Resources\JobCards\Schemas;

use App\Enums\JobCardItemType;
use App\Enums\JobCardStatus;
use App\Models\Part;
use App\Models\Service;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\Builder;

class JobCardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Base Information')
                    ->description('Base information about the job card')
                    ->columnSpanFull()
                    ->columns(['sm' => 1, 'md' => 2])
                    ->schema([
                        Select::make('customer_id')
                            ->live()
                            ->relationship('customer', 'email')
                            ->searchable()
                            ->required()
                            ->afterStateUpdated(function (Set $set) {
                                $set('vehicle_id', null);
                            }),
                        Select::make('vehicle_id')
                            ->relationship('vehicle', 'number_plate', function (Builder $query, Get $get) {
                                return $query->where('customer_id', $get('customer_id' ?? -1));
                            })
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('status')
                            ->options(JobCardStatus::class)
                            ->default(JobCardStatus::Pending)
                            ->required(),
                        Textarea::make('notes')
                            ->columnSpanFull(),
                    ]),
                Repeater::make('jobCardItems')
                    ->relationship('jobCardItems')
                    ->label('Job Card Items')
                    ->addActionLabel('Add Item')
                    ->columnSpanFull()
                    ->columns([
                        'sm' => 1,
                        'md' => 3,
                    ])
                    ->schema([
                        Select::make('type')
                            ->live()
                            ->options(JobCardItemType::class)
                            ->default(JobCardItemType::Service)
                            ->required()
                            ->afterStateUpdated(function (Set $set) {
                                self::clearForm($set);
                            }),
                        Select::make('service_id')
                            ->live()
                            ->relationship('service', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->hidden(fn (Get $get) => $get('type') != JobCardItemType::Service)
                            ->required(fn (Get $get) => $get('type') == JobCardItemType::Service)
                            ->afterStateUpdated(function (?int $state, Get $get, Set $set) {
                                if (! $state) {
                                    self::clearForm($set);
                                    self::updateTotals($get, $set, '../', '../../total');

                                    return;
                                }

                                $billable = Service::query()->findOrFail($state);

                                $set('quantity', 1);
                                $set('selling_price', $billable->selling_price);
                                $set('sub_total', $billable->selling_price);
                                self::updateTotals($get, $set, '../', '../../total');
                            }),
                        Select::make('part_id')
                            ->live()
                            ->relationship('part', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->hidden(fn (Get $get) => $get('type') != JobCardItemType::Part)
                            ->required(fn (Get $get) => $get('type') == JobCardItemType::Part)
                            ->afterStateUpdated(function (?int $state, Get $get, Set $set) {
                                if (! $state) {
                                    self::clearForm($set);
                                    self::updateTotals($get, $set, '../', '../../total');

                                    return;
                                }

                                $billable = Part::query()->findOrFail($state);

                                $set('quantity', 1);
                                $set('selling_price', $billable->selling_price);
                                $set('sub_total', $billable->selling_price);
                                self::updateTotals($get, $set, '../', '../../total');
                            }),
                        Select::make('employee_id')
                            ->relationship('employee', 'email')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        TextInput::make('quantity')
                            ->live(debounce: 500)
                            ->default(1)
                            ->numeric()
                            ->required()
                            ->afterStateUpdated(function (?int $state, Get $get, Set $set) {
                                if (! $state) {
                                    return;
                                }

                                $item = $get('');

                                $sellingPrice = self::getSellingPriceForItem($item);

                                $set('sub_total', $sellingPrice * $state);
                                self::updateTotals($get, $set, '../', '../../total');
                            }),
                        TextInput::make('selling_price')
                            ->prefix('KSH')
                            ->readOnly()
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->mask(RawJs::make('$money($input)')),
                        TextInput::make('sub_total')
                            ->prefix('KSH')
                            ->readOnly()
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->mask(RawJs::make('$money($input)')),
                    ])
                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                        $sellingPrice = self::getSellingPriceForItem($data);
                        $data['sub_total'] = $sellingPrice * intval($data['quantity']);

                        return $data;
                    })
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::updateTotals($get, $set);
                    }),
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Flex::make([
                            TextInput::make('total')
                                ->prefix('KSH')
                                ->readOnly()
                                ->extraInputAttributes(['style' => 'text-align: right'])
                                ->mask(RawJs::make('$money($input)'))
                                ->grow(false),
                        ])->alignEnd(),
                    ]),
            ]);
    }

    public static function clearForm(Set $set): void
    {
        $set('service_id', null);
        $set('part_id', null);
        $set('quantity', 1);
        $set('selling_price', null);
        $set('sub_total', null);
    }

    public static function updateTotals(Get $get, Set $set, string $itemsPath = 'jobCardItems', string $totalPath = '../../total'): void
    {
        // {'item-uuid': {...}, 'item-uuid2': {...}}
        $items = $get($itemsPath);

        $total = 0.0;

        foreach ($items as $item) {
            if (! $quantity = $item['quantity']) {
                continue;
            }

            $quantity = intval($item['quantity']);

            $sellingPrice = self::getSellingPriceForItem($item);

            $total += $sellingPrice * $quantity;
        }

        $set($totalPath, $total);
    }

    public static function getSellingPriceForItem(array $item): float
    {
        /** @var JobCardItemType */
        $type = $item['type'] instanceof JobCardItemType
            ? $item['type']
            : JobCardItemType::from($item['type']);
        $serviceId = $item['service_id'] ?? null;
        $partId = $item['part_id'] ?? null;

        if ($type == JobCardItemType::Service && empty($serviceId)) {
            return 0.0;
        }

        if ($type == JobCardItemType::Part && empty($partId)) {
            return 0.0;
        }

        $sellingPrice = $type == JobCardItemType::Part
            ? Part::query()->findOrFail($partId)->selling_price
            : Service::query()->findOrFail($serviceId)->selling_price;

        return $sellingPrice;
    }
}
