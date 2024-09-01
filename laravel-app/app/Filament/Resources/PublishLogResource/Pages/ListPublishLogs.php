<?php

namespace App\Filament\Resources\PublishLogResource\Pages;

use App\Filament\Resources\PublishLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPublishLogs extends ListRecords
{
    protected static string $resource = PublishLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
