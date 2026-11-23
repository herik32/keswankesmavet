<?php

namespace App\Filament\Resources\PemotonganKurbans\Pages;

use App\Filament\Resources\PemotonganKurbans\PemotonganKurbanResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePemotonganKurban extends CreateRecord
{
    protected static string $resource = PemotonganKurbanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
