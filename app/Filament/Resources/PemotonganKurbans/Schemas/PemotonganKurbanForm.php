<?php

namespace App\Filament\Resources\PemotonganKurbans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class PemotonganKurbanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tahun')
                    ->numeric()
                    ->length(4)
                    ->maxValue((int) date('Y'))
                    ->default(date('Y'))
                    ->required()
                    ->rules([
                        fn(string $operation, $record, callable $get) => Rule::unique('pemotongan_kurbans', 'tahun')
                            ->where('kabupaten_id', $get('kabupaten_id'))
                            ->where('jenis_ternak', $get('jenis_ternak'))
                            ->ignore($operation === 'edit' ? $record : null),
                    ])
                    ->validationMessages([
                        'unique' => 'Data untuk Tahun, Kabupaten dan Jenis Ternak ini sudah ada!',
                    ]),

                Select::make('kabupaten_id')
                    ->label('Kabupaten/Kota')
                    ->relationship('kabupaten', 'nama')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->rules([
                        fn(string $operation, $record, callable $get) => Rule::unique('pemotongan_kurbans', 'kabupaten_id')
                            ->where('jenis_ternak', $get('jenis_ternak'))
                            ->where('tahun', $get('tahun'))
                            ->ignore($operation === 'edit' ? $record : null),
                    ])
                    ->validationMessages([
                        'unique' => 'Data untuk Tahun, Kabupaten dan Jenis Ternak ini sudah ada!',
                    ]),

                Select::make('jenis_ternak')
                    ->label('Jenis Ternak')
                    ->options([
                        'Sapi' => 'Sapi',
                        'Kambing' => 'Kambing',
                        'Kerbau' => 'Kerbau',
                        'Domba' => 'Domba'
                    ])
                    ->required()
                    ->rules([
                        fn(string $operation, $record, callable $get) => Rule::unique('pemotongan_kurbans', 'jenis_ternak')
                            ->where('kabupaten_id', $get('kabupaten_id'))
                            ->where('tahun', $get('tahun'))
                            ->ignore($operation === 'edit' ? $record : null),
                    ])
                    ->validationMessages([
                        'unique' => 'Data untuk Tahun, Kabupaten dan Jenis Ternak ini sudah ada!',
                    ]),

                TextInput::make('jumlah_pemotongan')
                    ->label('Jumlah Pemotongan (Ekor)')
                    ->numeric()
                    ->minValue(0)
                    ->required(),
            ])->columns(1);
    }
}
