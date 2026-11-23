<?php

namespace App\Filament\Resources\TempatPemotongans\Pages;

use App\Filament\Resources\TempatPemotongans\TempatPemotonganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTempatPemotongans extends ListRecords
{
    protected static string $resource = TempatPemotonganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create new data')
                ->icon('fas-plus'),
        ];
    }
}
