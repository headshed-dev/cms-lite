<?php

namespace App\Filament\Resources\PublishLogResource\Pages;

use App\Filament\Resources\PublishLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPublishLog extends EditRecord
{
    protected static string $resource = PublishLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
