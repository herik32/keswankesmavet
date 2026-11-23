<?php

namespace App\Filament\Widgets;

use App\Models\PemotonganKurban;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class DoughnutChartWidget extends ChartWidget
{
    protected static ?int $sort = 3;
    protected ?string $maxHeight = '320px';
    protected int | string | array $columnSpan = [
        'default' => 1,
        'md' => 1,
        'lg' => 1,
        'xl' => 1,
    ];

    public function getHeading(): ?string
    {
        $tahunTerakhir = PemotonganKurban::max('tahun') ?? Carbon::now()->year;

        return "Komposisi Jenis Ternak Kurban ($tahunTerakhir)";
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'aspectRatio' => 1,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }

    protected function getData(): array
    {
        $tahunTerakhir = PemotonganKurban::max('tahun') ?? Carbon::now()->year;

        $dataTernak = PemotonganKurban::selectRaw('jenis_ternak, SUM(jumlah_pemotongan) as total')
            ->where('tahun', $tahunTerakhir)
            ->groupBy('jenis_ternak')
            ->pluck('total', 'jenis_ternak')
            ->toArray();

        $labels = array_keys($dataTernak);
        $data = array_values($dataTernak);

        $backgroundColors = [
            '#10b981',
            '#3b82f6',
            '#f59e0b',
            '#ef4444',
            '#8b5cf6',
            '#ec4899',
            '#64748b',
        ];

        return [
            'datasets' => [
                [
                    'label' => "Jumlah Pemotongan",
                    'data' => $data,
                    'backgroundColor' => array_slice($backgroundColors, 0, count($labels)),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
