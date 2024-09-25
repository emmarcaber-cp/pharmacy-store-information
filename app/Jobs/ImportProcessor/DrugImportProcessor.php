<?php

namespace App\Jobs\ImportProcessor;

use App\Models\Drug;
use Laravel\Nova\Nova;
use App\Models\DrugManufacturer;
use Illuminate\Support\Facades\Log;
use App\Exceptions\SaveRecordException;
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
        $drugManufacturer = DrugManufacturer::where(
            'name',
            trim($row['drug_manufacturer_name']),
        )->first();

        $drug = Drug::firstOrNew([
            'trade_name' => trim($row['trade_name']),
            'drug_manufacturer_id' => $drugManufacturer->id,
        ]);

        throw_if(
            $drug->save() === false,
            new SaveRecordException($drug)
        );
    }
}
