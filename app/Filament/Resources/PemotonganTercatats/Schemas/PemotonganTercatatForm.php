<?php

namespace App\Filament\Resources\PemotonganTercatats\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;

class PemotonganTercatatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('bulan')
                    ->label('Bulan')
                    ->type('month')
                    ->formatStateUsing(fn($state) => $state ? Carbon::parse($state)->format('Y-m') : null)
                    ->dehydrateStateUsing(fn($state) => $state ? "{$state}-01" : null)
                    ->required(),

                Select::make('tempat_pemotongan_id')
                    ->label('RPH/TPH')
                    ->relationship('tempatPemotongan', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('jenis_ternak')
                    ->label('Jenis Ternak')
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
                    ->searchable()
                    ->required(),

                TextInput::make('jumlah_pemotongan')
                    ->label('Jumlah Pemotongan (Ekor)')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->required(),
            ])->columns(1);
    }
}
