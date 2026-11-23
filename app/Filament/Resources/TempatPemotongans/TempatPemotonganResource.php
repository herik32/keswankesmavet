<?php

namespace App\Filament\Resources\TempatPemotongans;

use App\Filament\Resources\TempatPemotongans\Pages\CreateTempatPemotongan;
use App\Filament\Resources\TempatPemotongans\Pages\EditTempatPemotongan;
use App\Filament\Resources\TempatPemotongans\Pages\ListTempatPemotongans;
use App\Filament\Resources\TempatPemotongans\Schemas\TempatPemotonganForm;
use App\Filament\Resources\TempatPemotongans\Tables\TempatPemotongansTable;
use App\Models\TempatPemotongan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class TempatPemotonganResource extends Resource
{
    protected static ?string $model = TempatPemotongan::class;
    protected static string|BackedEnum|null $navigationIcon = 'fas-shop';
    protected static ?string $pluralModelLabel = 'Tempat Pemotongan';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return TempatPemotonganForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TempatPemotongansTable::configure($table);
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
            'index' => ListTempatPemotongans::route('/'),
            'create' => CreateTempatPemotongan::route('/create'),
            'edit' => EditTempatPemotongan::route('/{record}/edit'),
        ];
    }
}
