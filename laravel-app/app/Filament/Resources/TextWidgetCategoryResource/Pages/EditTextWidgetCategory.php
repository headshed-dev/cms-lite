<?php

namespace App\Filament\Resources\TextWidgetCategoryResource\Pages;

use App\Filament\Resources\TextWidgetCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTextWidgetCategory extends EditRecord
{
    protected static string $resource = TextWidgetCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
