<?php

namespace App\Filament\Resources\PemotonganKurbans\Pages;

use App\Filament\Resources\PemotonganKurbans\PemotonganKurbanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPemotonganKurban extends EditRecord
{
    protected static string $resource = PemotonganKurbanResource::class;

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
