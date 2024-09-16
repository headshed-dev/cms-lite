<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublishLogResource\Pages;
use App\Filament\Resources\PublishLogResource\RelationManagers;
use App\Models\PublishLog;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PublishLogResource extends Resource

{
    protected static ?string $model = PublishLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Configuration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('description')
                    ->label('Changes made to the website before publishing to the web')
                    ->required(),
                TextInput::make('user_id')
                    ->default(auth()->user()->id)
                    ->required()
                    ->hidden(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc') // Set default sorting to most recent first
            ->columns([
                TextColumn::make('updated_at')
                    ->searchable()
                    ->sortable()
                    ->label('Date Published'),
                TextColumn::make('description')
                    ->searchable()
                    ->label('Changes Made'),
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('User Name'),
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
            'index' => Pages\ListPublishLogs::route('/'),
            'create' => Pages\CreatePublishLog::route('/create'),
            'edit' => Pages\EditPublishLog::route('/{record}/edit'),
        ];
    }
}
