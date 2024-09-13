<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MetadataCategoryResource\Pages;
use App\Filament\Resources\MetadataCategoryResource\RelationManagers;
use App\Models\MetadataCategory;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MetadataCategoryResource extends Resource
{
    protected static ?string $model = MetadataCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationParentItem = 'Metadata';

    protected static ?string $navigationGroup = 'Partials';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListMetadataCategories::route('/'),
            'create' => Pages\CreateMetadataCategory::route('/create'),
            'edit' => Pages\EditMetadataCategory::route('/{record}/edit'),
        ];
    }
}
