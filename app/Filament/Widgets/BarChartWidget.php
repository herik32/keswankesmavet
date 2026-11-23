<?php

namespace App\Filament\Widgets;

use App\Models\PemotonganTercatat;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class BarChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;
    protected ?string $maxHeight = '320px';
    protected int | string | array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'lg' => 2,
        'xl' => 2,
    ];

    public function getHeading(): ?string
    {
        $tahunTerakhir = PemotonganTercatat::max('bulan')
            ? Carbon::parse(PemotonganTercatat::max('bulan'))->year
            : Carbon::now()->year;

        return "Tren Pemotongan Tercatat Bulanan ($tahunTerakhir)";
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'aspectRatio' => 1.8,
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }

    protected function getData(): array
    {
        $tahunTerakhir = PemotonganTercatat::max('bulan')
            ? Carbon::parse(PemotonganTercatat::max('bulan'))->year
            : Carbon::now()->year;

        $dataPemotongan = PemotonganTercatat::selectRaw('MONTH(bulan) as month_num, SUM(jumlah_pemotongan) as total')
            ->whereYear('bulan', $tahunTerakhir)
            ->groupBy('month_num')
            ->pluck('total', 'month_num')
            ->toArray();

        $labels = [];
        $data = [];

        for ($m = 1; $m <= 12; $m++) {
            $labels[] = Carbon::create()->month($m)->translatedFormat('F');
            $data[] = $dataPemotongan[$m] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => "Jumlah Pemotongan",
                    'data' => $data,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
