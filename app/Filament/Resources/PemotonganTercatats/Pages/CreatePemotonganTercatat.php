<?php

namespace App\Filament\Resources\PemotonganTercatats\Pages;

use App\Filament\Resources\PemotonganTercatats\PemotonganTercatatResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePemotonganTercatat extends CreateRecord
{
    protected static string $resource = PemotonganTercatatResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
