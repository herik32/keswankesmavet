<?php

namespace App\Filament\Resources\TempatPemotongans\Pages;

use App\Filament\Resources\TempatPemotongans\TempatPemotonganResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTempatPemotongan extends EditRecord
{
    protected static string $resource = TempatPemotonganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
