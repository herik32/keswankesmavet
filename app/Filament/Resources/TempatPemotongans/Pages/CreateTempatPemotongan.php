<?php

namespace App\Filament\Resources\TempatPemotongans\Pages;

use App\Filament\Resources\TempatPemotongans\TempatPemotonganResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTempatPemotongan extends CreateRecord
{
    protected static string $resource = TempatPemotonganResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
