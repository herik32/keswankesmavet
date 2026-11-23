<?php

namespace App\Filament\Resources\PemotonganTercatats\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PemotonganTercatatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bulan')
                    ->label('BULAN')
                    ->date('F Y')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereRaw("DATE_FORMAT(bulan, '%M %Y') LIKE ?", ["%{$search}%"]);
                    })
                    ->sortable(),

                TextColumn::make('tempatPemotongan.nama')
                    ->label('RPH/TPH')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tempatPemotongan.kabupaten.nama')
                    ->label('KABUPATEN/KOTA')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jenis_ternak')
                    ->label('JENIS TERNAK')
                    ->searchable()
                    ->sortable(),

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
