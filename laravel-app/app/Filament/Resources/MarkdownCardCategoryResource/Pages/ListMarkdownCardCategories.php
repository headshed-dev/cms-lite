<?php

namespace App\Filament\Resources\MarkdownCardCategoryResource\Pages;

use App\Filament\Resources\MarkdownCardCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMarkdownCardCategories extends ListRecords
{
    protected static string $resource = MarkdownCardCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
