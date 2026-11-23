<?php

namespace App\Exports;

use App\Models\PemotonganKurban;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PemotonganKurbanExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $tahunAwal;
    protected $tahunAkhir;
    protected $kabupaten;
    protected $ternak;

    public function __construct(?int $tahunAwal = null, ?int $tahunAkhir = null, ?string $kabupaten = null, ?string $ternak = null)
    {
        $this->tahunAwal = $tahunAwal;
        $this->tahunAkhir = $tahunAkhir;
        $this->kabupaten = $kabupaten;
        $this->ternak = $ternak;
    }

    public function query(): Builder
    {
        $query = PemotonganKurban::query()->with('kabupaten');

        if ($this->tahunAwal && $this->tahunAkhir) {
            $query->whereBetween('tahun', [$this->tahunAwal, $this->tahunAkhir]);
        }

        if ($this->kabupaten) {
            $query->where('kabupaten_id', $this->kabupaten);
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
            'Tahun',
            'Kabupaten/Kota',
            'Jenis Ternak',
            'Jumlah Pemotongan',
        ];
    }

    public function map($row): array
    {
        static $no = 1;

        return [
            $no++,
            $row->tahun,
            $row->kabupaten->nama,
            $row->jenis_ternak,
            $row->jumlah_pemotongan,
        ];
    }
}
