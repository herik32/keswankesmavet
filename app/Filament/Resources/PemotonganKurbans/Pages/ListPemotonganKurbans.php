<?php

namespace App\Filament\Resources\PemotonganKurbans\Pages;

use App\Exports\PemotonganKurbanExport;
use App\Filament\Resources\PemotonganKurbans\PemotonganKurbanResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Grid;
use Maatwebsite\Excel\Facades\Excel;

class ListPemotonganKurbans extends ListRecords
{
    protected static string $resource = PemotonganKurbanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewDashboard')
                ->label('View Dashboard')
                ->icon('fas-gauge')
                ->url('/dashboardpemotongankurban')
                ->openUrlInNewTab(),
            Action::make('exportFilterExcel')
                ->label('Export excel')
                ->icon('far-file-excel')
                ->modalHeading('Export Pemotongan Kurban')
                ->modalDescription('Pilih rentang tahun, kabupaten dan jenis ternak untuk menyaring data yang akan di-export.')
                ->modalSubmitActionLabel('Download Excel')
                ->form([
                    Grid::make(2)->schema([
                        TextInput::make('tahun_awal')
                            ->label('Tahun Awal')
                            ->numeric()
                            ->length(4)
                            ->maxValue((int) date('Y'))
                            ->default(date('Y'))
                            ->required(),

                        TextInput::make('tahun_akhir')
                            ->label('Tahun Akhir')
                            ->numeric()
                            ->length(4)
                            ->maxValue((int) date('Y'))
                            ->default(date('Y'))
                            ->required(),
                    ]),

                    Select::make('kabupaten')
                        ->label('Kabupaten/Kota')
                        ->placeholder('Semua Kabupaten/Kota')
                        ->relationship('kabupaten', 'nama')
                        ->searchable()
                        ->preload()
                        ->nullable(),

                    Select::make('ternak')
                        ->label('Jenis Ternak')
                        ->placeholder('Semua Jenis Ternak')
                        ->options([
                            'Sapi' => 'Sapi',
                            'Kambing' => 'Kambing',
                            'Kerbau' => 'Kerbau',
                            'Domba' => 'Domba'
                        ])
                        ->nullable(),
                ])
                ->action(function (array $data) {
                    $tahunAwal = (int) $data['tahun_awal'];
                    $tahunAkhir = (int) $data['tahun_akhir'];
                    $kabupaten = $data['kabupaten'];
                    $ternak = $data['ternak'];

                    $fileName = 'data-pemotongan-kurban-kalbar';
                    $fileName .= "-{$tahunAwal}-{$tahunAkhir}.xlsx";

                    return Excel::download(
                        new PemotonganKurbanExport($tahunAwal, $tahunAkhir, $kabupaten, $ternak),
                        $fileName
                    );
                }),
            CreateAction::make()
                ->label('Create new data')
                ->icon('fas-plus'),
        ];
    }
}
