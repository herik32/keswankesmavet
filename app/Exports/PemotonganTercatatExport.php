<?php

namespace App\Exports;

use App\Models\PemotonganTercatat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PemotonganTercatatExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $bulanAwal;
    protected $bulanAkhir;
    protected $ternak;

    public function __construct(?string $bulanAwal = null, ?string $bulanAkhir = null, ?string $ternak = null)
    {
        $this->bulanAwal = $bulanAwal;
        $this->bulanAkhir = $bulanAkhir;
        $this->ternak = $ternak;
    }

    public function query(): Builder
    {
        $query = PemotonganTercatat::query()->with('tempatPemotongan');

        if ($this->bulanAwal && $this->bulanAkhir) {
            $startDate = Carbon::parse($this->bulanAwal)->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::parse($this->bulanAkhir)->endOfMonth()->format('Y-m-d');
            $query->whereBetween('bulan', [$startDate, $endDate]);
        }

        if ($this->ternak) {
            $query->where('jenis_ternak', $this->ternak);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Bulan',
            'RPH/TPH',
            'Jenis Ternak',
            'Jumlah Pemotongan',
        ];
    }

    public function map($row): array
    {
        static $no = 1;

        return [
            $no++,
            Carbon::parse($row->bulan)->format('F Y'),
            $row->tempatPemotongan->nama,
            $row->jenis_ternak,
            $row->jumlah_pemotongan,
        ];
    }
}
