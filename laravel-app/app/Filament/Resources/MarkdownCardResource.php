<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MarkdownCardResource\Pages;
use App\Filament\Resources\MarkdownCardResource\RelationManagers;
use App\Models\MarkdownCard;
use App\Models\MarkdownCardCategory;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Markdown;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MarkdownCardResource extends Resource
{
    protected static ?string $model = MarkdownCard::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Partials';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                MarkdownEditor::make('content')
                    ->label('Content')
                    ->required()
                    ->fileAttachmentsDirectory('images')
                    ->columnSpanFull(),
                Select::make('markdown_card_category_id')
                    ->label('Category')
                    ->options(MarkdownCardCategory::pluck('name', 'id')->toArray())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable(true)
                    ->sortable(true),
                TextColumn::make('markdownCardCategory.name')
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
            'index' => Pages\ListMarkdownCards::route('/'),
            'create' => Pages\CreateMarkdownCard::route('/create'),
            'edit' => Pages\EditMarkdownCard::route('/{record}/edit'),
        ];
    }
}
