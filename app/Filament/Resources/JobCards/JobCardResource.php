<?php

namespace App\Filament\Resources\JobCards;

use App\Filament\Resources\JobCards\Pages\CreateJobCard;
use App\Filament\Resources\JobCards\Pages\EditJobCard;
use App\Filament\Resources\JobCards\Pages\ListJobCards;
use App\Filament\Resources\JobCards\Pages\ViewJobCard;
use App\Filament\Resources\JobCards\Schemas\JobCardForm;
use App\Filament\Resources\JobCards\Schemas\JobCardInfolist;
use App\Filament\Resources\JobCards\Tables\JobCardsTable;
use App\Models\JobCard;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class JobCardResource extends Resource
{
    protected static ?string $model = JobCard::class;

    protected static ?string $recordTitleAttribute = 'id';

    protected static string|UnitEnum|null $navigationGroup = 'Workshop Operations';

    protected static ?int $navigationSort = 0;

    public static function form(Schema $schema): Schema
    {
        return JobCardForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return JobCardInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobCardsTable::configure($table);
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
            'index' => ListJobCards::route('/'),
            'create' => CreateJobCard::route('/create'),
            'view' => ViewJobCard::route('/{record}'),
            'edit' => EditJobCard::route('/{record}/edit'),
        ];
    }
}
