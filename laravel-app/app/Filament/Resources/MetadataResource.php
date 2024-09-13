<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MetadataResource\Pages;
use App\Filament\Resources\MetadataResource\RelationManagers;
use App\Models\Metadata;
use App\Models\MetadataCategory;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MetadataResource extends Resource
{
    protected static ?string $model = Metadata::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass';

    protected static ?string $navigationGroup = 'Partials';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                TextInput::make('description')
                    ->label('Description')
                    ->required(),
                TextInput::make('keywords')
                    ->label('Keywords')
                    ->required(),
                Select::make('metadata_category_id')
                    ->label('Category')
                    ->options(MetadataCategory::pluck('name', 'id')->toArray())
                    ->required(),
                    FileUpload::make('image')
                    ->disk('public')
                    ->directory('metadata')
                    ->label('Image')
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('keywords')
                    ->label('Keywords')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('metadataCategory.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListMetadata::route('/'),
            'create' => Pages\CreateMetadata::route('/create'),
            'edit' => Pages\EditMetadata::route('/{record}/edit'),
        ];
    }
}
