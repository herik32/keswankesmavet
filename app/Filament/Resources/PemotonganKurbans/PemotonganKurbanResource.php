<?php

namespace App\Filament\Resources\PemotonganKurbans;

use App\Filament\Resources\PemotonganKurbans\Pages\CreatePemotonganKurban;
use App\Filament\Resources\PemotonganKurbans\Pages\EditPemotonganKurban;
use App\Filament\Resources\PemotonganKurbans\Pages\ListPemotonganKurbans;
use App\Filament\Resources\PemotonganKurbans\Schemas\PemotonganKurbanForm;
use App\Filament\Resources\PemotonganKurbans\Tables\PemotonganKurbansTable;
use App\Models\PemotonganKurban;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PemotonganKurbanResource extends Resource
{
    protected static ?string $model = PemotonganKurban::class;
    protected static string|BackedEnum|null $navigationIcon = 'fas-cow';
    protected static ?string $pluralModelLabel = 'Pemotongan Kurban';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PemotonganKurbanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PemotonganKurbansTable::configure($table);
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
            'index' => ListPemotonganKurbans::route('/'),
            'create' => CreatePemotonganKurban::route('/create'),
            'edit' => EditPemotonganKurban::route('/{record}/edit'),
        ];
    }
}
