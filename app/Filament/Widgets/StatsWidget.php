<?php

namespace App\Filament\Widgets;

use App\Models\PemotonganKurban;
use App\Models\PemotonganTercatat;
use App\Models\TempatPemotongan;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $tahunKurban = PemotonganKurban::max('tahun');

        $tahunTercatat = PemotonganTercatat::max('bulan')
            ? Carbon::parse(PemotonganTercatat::max('bulan'))->year
            : null;

        // Pemotongan Kurban
        $totalKurban = PemotonganKurban::where('tahun', $tahunKurban)
            ->sum('jumlah_pemotongan') ?? 0;

        // Pemotongan Tercatat
        $totalTercatat = PemotonganTercatat::whereYear('bulan', $tahunTercatat)
            ->sum('jumlah_pemotongan') ?? 0;

        // Tempat Pemotongan Aktif
        $tempatAktif = TempatPemotongan::where('status_aktif', true)->count();

        return [
            Stat::make("Pemotongan Kurban ($tahunKurban)", number_format($totalKurban, 0, ',', '.') . ' Ekor')
                ->description("Total pemotongan kurban tahun $tahunKurban")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make("Pemotongan Tercatat ($tahunTercatat)", number_format($totalTercatat, 0, ',', '.') . ' Ekor')
                ->description("Total pemotongan tercatat tahun $tahunTercatat")
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('info'),

            Stat::make('RPH/TPH Aktif', $tempatAktif . ' Unit')
                ->description('RPH/TPH yang masih beroperasi')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary'),
        ];
    }
}
