<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Tables;
use App\Models\Image;
use Filament\Forms\Form;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\ImageCategory;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ImageResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ImageResource\RelationManagers;
use App\Tables\Columns\UrlColumn;
use Filament\Forms\Components\ViewField;
use Filament\Tables\Columns\Column;

class ImageResource extends Resource
{
    protected static ?string $model = Image::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Partials';

    public function myImageUrl()
    {
        // Return the custom string you want to display
        return 'https://example.com/custom-image-url';
    }

    protected function getViewData()
    {
        return [
            'message' => $this->myImageUrl(), // Call the function and pass its result
            'max' => 5,
            'step' => 1
        ];
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->disk('public')
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])

                    ->storeFileNamesIn('attachment_file_name')
                    ->directory('images')
                    ->label('Image')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('alt')
                    ->label('Alt')
                    ->required(),
                TextInput::make('description')
                    ->label('Description')
                    ->required(),



                Select::make('category_id')
                    ->label('Category')
                    ->options(
                        ImageCategory::all()->pluck('name', 'id')
                            ->toArray()
                    ),

            ]);
    }


    // Function to return the image URL
    public function getImageUrl($record)
    {
        dd($record);
        // Replace with your logic to generate the image URL
        return 'https://example.com/images/' . $record->image_path;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                UrlColumn::make('image_url')
                    ->label('URL'),

                ImageColumn::make('image')
                    ->label('Image'),


                TextColumn::make('alt')
                    ->label('Alt')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Description')
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
            'index' => Pages\ListImages::route('/'),
            'create' => Pages\CreateImage::route('/create'),
            'edit' => Pages\EditImage::route('/{record}/edit'),
        ];
    }
}
