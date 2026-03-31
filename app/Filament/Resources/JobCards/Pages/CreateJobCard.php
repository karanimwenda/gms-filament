<?php

namespace App\Filament\Resources\JobCards\Pages;

use App\Filament\Resources\JobCards\JobCardResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJobCard extends CreateRecord
{
    protected static string $resource = JobCardResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (array_key_exists('total', $data)) {
            unset($data['total']);
        }

        return $data;
    }
}
