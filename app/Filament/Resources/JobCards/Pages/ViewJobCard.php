<?php

namespace App\Filament\Resources\JobCards\Pages;

use App\Filament\Resources\JobCards\JobCardResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewJobCard extends ViewRecord
{
    protected static string $resource = JobCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
