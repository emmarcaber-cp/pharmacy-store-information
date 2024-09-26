<?php

namespace App\Jobs\ImportProcessor;

use Laravel\Nova\Nova;
use App\Models\DrugManufacturer;
use App\Exceptions\SaveRecordException;
use Coreproc\NovaDataSync\Import\Jobs\ImportProcessor;

class DrugManufacturerImportProcessor extends ImportProcessor
{
    public static function expectedHeaders(): array
    {
        return [
            'name',
            'address'
        ];
    }

    protected function rules(array $row, int $rowIndex): array
    {
        return [
            'name' => [
                'required',
                'max:255'
            ],
            'address' => [
                'required',
                'max:255'
            ],
        ];
    }

    protected function process(array $row, int $rowIndex): void
    {
        $drugManufacturer = DrugManufacturer::firstOrNew([
            'name' => $row['name'],
        ]);

        $drugManufacturer->address = trim($row['address']);

        throw_if(
            $drugManufacturer->save() === false,
            new SaveRecordException($drugManufacturer)
        );
    }
}
