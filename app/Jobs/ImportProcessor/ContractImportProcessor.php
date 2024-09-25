<?php

namespace App\Jobs\ImportProcessor;

use App\Models\Contract;
use App\Models\Pharmacy;
use App\Models\DrugManufacturer;
use Illuminate\Support\Facades\Log;
use Coreproc\NovaDataSync\Import\Jobs\ImportProcessor;

class ContractImportProcessor extends ImportProcessor
{
    public static function expectedHeaders(): array
    {
        return ['pharmacy_name', 'drug_manufacturer_name', 'start_date', 'end_date'];
    }

    protected function rules(array $row, int $rowIndex): array
    {
        return [
            'pharmacy_name' => ['required', 'max:255', 'exists:pharmacies,name'],
            'drug_manufacturer_name' => ['required', 'max:255', 'exists:drug_manufacturers,name'],
            'start_date' => ['required', 'date_format:Y-m-d H:i:s', 'before:end_date'],
            'end_date' => ['required', 'date_format:Y-m-d H:i:s', 'after:start_date'],
        ];
    }

    protected function process(array $row, int $rowIndex): void
    {
        $pharmacy = Pharmacy::where('name', $row['pharmacy_name'])->first();
        $drugManufacturer = DrugManufacturer::where('name', $row['drug_manufacturer_name'])->first();

        Contract::firstOrCreate([
            'pharmacy_id' => $pharmacy->id,
            'drug_manufacturer_id' => $drugManufacturer->id,
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
        ], [
            'pharmacy_id' => $pharmacy->id,
            'drug_manufacturer_id' => $drugManufacturer->id,
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
        ]);
    }
}
