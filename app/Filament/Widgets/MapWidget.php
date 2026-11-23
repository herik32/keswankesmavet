<?php

namespace App\Filament\Widgets;

use App\Models\TempatPemotongan;
use Filament\Widgets\Widget;

class MapWidget extends Widget
{
    protected string $view = 'filament.widgets.map-widget';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function getTempatPemotonganData(): array
    {
        return TempatPemotongan::where('status_aktif', 1)
            ->whereNotNull('latitude')->whereNotNull('longitude')
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->nama,
                    'lat' => (float) $item->latitude,
                    'lng' => (float) $item->longitude,
                ];
            })
            ->toArray();
    }
}
