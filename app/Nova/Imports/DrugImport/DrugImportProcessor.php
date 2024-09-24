<?php

namespace App\Nova\Imports\DrugImport;

use App\Models\Drug;
use App\Models\DrugManufacturer;
use Illuminate\Support\Facades\Log;
use Coreproc\NovaDataSync\Import\Jobs\ImportProcessor;

class DrugImportProcessor extends ImportProcessor
{
    public static function expectedHeaders(): array
    {
        return ['drug_manufacturer_name', 'trade_name'];
    }

    protected function rules(array $row, int $rowIndex): array
    {
        return [
            'drug_manufacturer_name' => ['required', 'max:255', 'exists:drug_manufacturers,name'],
            'trade_name' => ['required', 'max:255'],
        ];
    }

    protected function process(array $row, int $rowIndex): void
    {
        Log::info('processing row ' . $rowIndex);

        $drugManufacturer = DrugManufacturer::where('name', $row['drug_manufacturer_name'])->first();

        Drug::firstOrCreate(
            ['trade_name' => $row['trade_name']],
            [
                'trade_name' => $row['trade_name'],
                'drug_manufacturer_id' => $drugManufacturer->id,
            ]
        );
    }

    public static function chunkSize(): int
    {
        return 100;
    }
}
