<?php

namespace App\Filament\Resources\TechniqueResource\Pages;

use App\Filament\Resources\TechniqueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTechnique extends EditRecord
{
    protected static string $resource = TechniqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

