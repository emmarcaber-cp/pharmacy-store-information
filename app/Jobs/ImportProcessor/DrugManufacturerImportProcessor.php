<?php

namespace App\Jobs\ImportProcessor;

use App\Models\DrugManufacturer;
use Illuminate\Support\Facades\Log;
use Coreproc\NovaDataSync\Import\Jobs\ImportProcessor;

class DrugManufacturerImportProcessor extends ImportProcessor
{
    public static function expectedHeaders(): array
    {
        return ['name', 'address'];
    }

    protected function rules(array $row, int $rowIndex): array
    {
        return [
            'name' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
        ];
    }

    protected function process(array $row, int $rowIndex): void
    {
        DrugManufacturer::firstOrCreate([
            'name' => $row['name'],
            'address' => $row['address'],
        ]);
    }

    public static function chunkSize(): int
    {
        return 100;
    }
}
