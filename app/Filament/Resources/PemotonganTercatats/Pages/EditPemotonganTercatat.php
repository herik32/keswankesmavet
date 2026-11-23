<?php

namespace App\Filament\Resources\PemotonganTercatats\Pages;

use App\Filament\Resources\PemotonganTercatats\PemotonganTercatatResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPemotonganTercatat extends EditRecord
{
    protected static string $resource = PemotonganTercatatResource::class;

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
