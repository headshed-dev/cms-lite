<?php

namespace App\Filament\Resources\MetadataCategoryResource\Pages;

use App\Filament\Resources\MetadataCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMetadataCategories extends ListRecords
{
    protected static string $resource = MetadataCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
