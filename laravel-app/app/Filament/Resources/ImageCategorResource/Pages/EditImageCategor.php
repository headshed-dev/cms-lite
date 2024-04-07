<?php

namespace App\Filament\Resources\ImageCategorResource\Pages;

use App\Filament\Resources\ImageCategorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditImageCategor extends EditRecord
{
    protected static string $resource = ImageCategorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
