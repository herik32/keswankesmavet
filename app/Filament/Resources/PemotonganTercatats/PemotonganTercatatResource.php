<?php

namespace App\Filament\Resources\PemotonganTercatats;

use App\Filament\Resources\PemotonganTercatats\Pages\CreatePemotonganTercatat;
use App\Filament\Resources\PemotonganTercatats\Pages\EditPemotonganTercatat;
use App\Filament\Resources\PemotonganTercatats\Pages\ListPemotonganTercatats;
use App\Filament\Resources\PemotonganTercatats\Schemas\PemotonganTercatatForm;
use App\Filament\Resources\PemotonganTercatats\Tables\PemotonganTercatatsTable;
use App\Models\PemotonganTercatat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PemotonganTercatatResource extends Resource
{
    protected static ?string $model = PemotonganTercatat::class;
    protected static string|BackedEnum|null $navigationIcon = 'fas-clipboard-list';
    protected static ?string $pluralModelLabel = 'Pemotongan Tercatat';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return PemotonganTercatatForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PemotonganTercatatsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPemotonganTercatats::route('/'),
            'create' => CreatePemotonganTercatat::route('/create'),
            'edit' => EditPemotonganTercatat::route('/{record}/edit'),
        ];
    }
}
