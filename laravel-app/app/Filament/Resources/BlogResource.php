<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Blog;
use Filament\Forms\Components\Checkbox;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
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
                Section::make('create a new post')
                    ->columns(2)
                    ->description('Blog post details')
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
                            ->label('Tags'),
                        Select::make('category_id')
                            ->label('Category to post')
                            ->options(BlogCategory::pluck('name', 'id')->toArray())
                            ->required(),
                        DateTimePicker::make('blog_date')
                            ->label('date')
                            ->seconds(false)->default(now()),
                        Checkbox::make('is_featured')
                            ->label('Featured'),
                    ]),

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
            ->description('Blog posts')
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->label('Title')
                    ->sortable(true),
                TextColumn::make('blog_date')
                    ->searchable()
                    ->label('Date')
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable(true)
                    ->sortable(true),
                BooleanColumn::make('is_featured')
                    ->label('Featured')
                    ->sortable(true)
                    ->alignCenter(),

                ImageColumn::make('image')
                    ->searchable()
                    ->label('Image'),
                TextColumn::make('tags')
                    ->searchable()
                    ->label('Tags'),

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
