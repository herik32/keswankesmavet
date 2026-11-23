<?php

namespace App\Filament\Resources\PemotonganTercatats\Pages;

use App\Exports\PemotonganTercatatExport;
use App\Filament\Resources\PemotonganTercatats\PemotonganTercatatResource;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Grid;
use Maatwebsite\Excel\Facades\Excel;

class ListPemotonganTercatats extends ListRecords
{
    protected static string $resource = PemotonganTercatatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewDashboard')
                ->label('View Dashboard')
                ->icon('fas-gauge')
                ->url('/dashboardpemotongantercatat')
                ->openUrlInNewTab(),
            Action::make('exportFilterExcel')
                ->label('Export excel')
                ->icon('far-file-excel')
                ->modalHeading('Export Pemotongan Tercatat')
                ->modalDescription('Pilih rentang bulan dan jenis ternak untuk menyaring data yang akan di-export.')
                ->modalSubmitActionLabel('Download Excel')
                ->form([
                    Grid::make(2)->schema([
                        TextInput::make('bulan_awal')
                            ->label('Bulan Awal')
                            ->type('month')
                            ->formatStateUsing(fn($state) => $state ? Carbon::parse($state)->format('Y-m') : null)
                            ->dehydrateStateUsing(fn($state) => $state ? "{$state}-01" : null)
                            ->required(),

                        TextInput::make('bulan_akhir')
                            ->label('Bulan Akhir')
                            ->type('month')
                            ->formatStateUsing(fn($state) => $state ? Carbon::parse($state)->format('Y-m') : null)
                            ->dehydrateStateUsing(fn($state) => $state ? "{$state}-01" : null)
                            ->required(),
                    ]),

                    Select::make('ternak')
                        ->label('Jenis Ternak')
                        ->placeholder('Semua Jenis Ternak')
                        ->options([
                            'Ayam' => 'Ayam',
                            'Babi' => 'Babi',
                            'Kambing' => 'Kambing',
                            'Kerbau Jantan' => 'Kerbau Jantan',
                            'Kerbau Betina Produktif' => 'Kerbau Betina Produktif',
                            'Kerbau Betina Tidak Produktif' => 'Kerbau Betina Tidak Produktif',
                            'Sapi Jantan' => 'Sapi Jantan',
                            'Sapi Betina Produktif' => 'Sapi Betina Produktif',
                            'Sapi Betina Tidak Produktif' => 'Sapi Betina Tidak Produktif',
                        ])
                        ->nullable(),
                ])
                ->action(function (array $data) {
                    $bulanAwal = $data['bulan_awal'];
                    $bulanAkhir = $data['bulan_akhir'];
                    $ternak = $data['ternak'];

                    $fileName = 'data-pemotongan-tercatat-kalbar';
                    $fileName .= "-{$bulanAwal}-{$bulanAkhir}.xlsx";

                    return Excel::download(
                        new PemotonganTercatatExport($bulanAwal, $bulanAkhir, $ternak),
                        $fileName
                    );
                }),
            CreateAction::make()
                ->label('Create new data')
                ->icon('fas-plus')
        ];
    }
}
