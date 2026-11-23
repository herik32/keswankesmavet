<?php

namespace App\Filament\Resources\PemotonganKurbans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PemotonganKurbansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tahun')
                    ->label('TAHUN')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('kabupaten.nama')
                    ->label('KABUPATEN/KOTA')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('jenis_ternak')
                    ->label('JENIS TERNAK')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Sapi' => 'success',
                        'Kambing' => 'warning',
                        'Domba' => 'info',
                        'Kerbau' => 'danger',
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable()
                    ->alignCenter(),

                TextColumn::make('jumlah_pemotongan')
                    ->label('JUMLAH PEMOTONGAN')
                    ->numeric()
                    ->sortable()
                    ->alignEnd(),
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
