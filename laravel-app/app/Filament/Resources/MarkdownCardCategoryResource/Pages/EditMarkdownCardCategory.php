<?php

namespace App\Filament\Resources\MarkdownCardCategoryResource\Pages;

use App\Filament\Resources\MarkdownCardCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMarkdownCardCategory extends EditRecord
{
    protected static string $resource = MarkdownCardCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
