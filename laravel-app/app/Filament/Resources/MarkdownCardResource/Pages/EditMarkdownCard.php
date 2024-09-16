<?php

namespace App\Filament\Resources\MarkdownCardResource\Pages;

use App\Filament\Resources\MarkdownCardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMarkdownCard extends EditRecord
{
    protected static string $resource = MarkdownCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
