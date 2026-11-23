<?php

namespace App\Filament\Resources\TempatPemotongans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TempatPemotonganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),

                Select::make('kabupaten_id')
                    ->label('Kabupaten/Kota')
                    ->relationship('kabupaten', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('latitude')
                    ->numeric()
                    ->minValue(-90)
                    ->maxValue(90)
                    ->placeholder('-0.xxxxxx')
                    ->helperText('Koordinat Garis Lintang'),

                TextInput::make('longitude')
                    ->numeric()
                    ->minValue(-180)
                    ->maxValue(180)
                    ->placeholder('109.xxxxxx')
                    ->helperText('Koordinat Garis Bujur'),

                Toggle::make('status_aktif')
                    ->label('Status Aktif')
                    ->default(true)
                    ->required(),
            ])->columns(1);
    }
}
