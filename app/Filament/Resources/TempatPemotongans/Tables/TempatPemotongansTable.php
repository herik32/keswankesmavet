<?php

namespace App\Filament\Resources\TempatPemotongans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TempatPemotongansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('NAMA')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('kabupaten.nama')
                    ->label('KABUPATEN/KOTA')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('latitude')
                    ->label('LATITUDE')
                    ->numeric(decimalPlaces: 8)
                    ->alignCenter(),

                TextColumn::make('longitude')
                    ->label('LONGITUDE')
                    ->numeric(decimalPlaces: 8)
                    ->alignCenter(),

                IconColumn::make('status_aktif')
                    ->label('STATUS')
                    ->boolean()
                    ->sortable()
                    ->alignCenter(),

            ])
            ->filters([
                //
            ])
            ->defaultSort('id', 'desc')
            ->recordActions([
                EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit data'),
                DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Delete data'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
