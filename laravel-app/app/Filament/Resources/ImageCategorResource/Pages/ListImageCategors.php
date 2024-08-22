<?php

namespace App\Filament\Resources\ImageCategorResource\Pages;

use App\Filament\Resources\ImageCategorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListImageCategors extends ListRecords
{
    protected static string $resource = ImageCategorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
