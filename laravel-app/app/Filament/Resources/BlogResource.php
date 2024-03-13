<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Blog;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\BlogResource\Pages;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('new post')
                    ->description('news and views')
                    ->collapsible()
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, string $state, Forms\Set $set) {
                                // dump($operation);
                                // dump($state);
                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required(),
                        TextInput::make('description')
                            ->label('Description'),
                        TextInput::make('keywords')
                            ->label('Keywords'),
                        TagsInput::make('tags')
                            ->label('Tags')
                    ])->columns(2),

                MarkdownEditor::make('content')
                    ->label('Content')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->disk('public')
                    ->directory('images')
                    ->label('Image')
                    ->columnSpanFull(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->label('Title'),
                TextColumn::make('slug')
                    ->searchable()
                    ->label('Slug'),
                TextColumn::make('description')
                    ->searchable()
                    ->label('Description'),
                TextColumn::make('keywords')
                    ->searchable()
                    ->label('Keywords'),
                ImageColumn::make('image')
                    ->searchable()
                    ->label('Image'),
                TextColumn::make('tags')
                    ->searchable()
                    ->label('Tags'),
                TextColumn::make('likes')
                    ->searchable()
                    ->label('Likes')
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
