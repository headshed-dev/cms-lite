<?php

namespace App\Filament\Resources\MetadataCategoryResource\Pages;

use App\Filament\Resources\MetadataCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMetadataCategory extends EditRecord
{
    protected static string $resource = MetadataCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
