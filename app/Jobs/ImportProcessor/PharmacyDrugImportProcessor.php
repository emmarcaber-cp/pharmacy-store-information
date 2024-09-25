<?php

namespace App\Jobs\ImportProcessor;

use App\Models\Drug;
use App\Models\Pharmacy;
use App\Models\PharmacyDrug;
use App\Models\DrugManufacturer;
use Illuminate\Support\Facades\Log;
use Coreproc\NovaDataSync\Import\Jobs\ImportProcessor;

class PharmacyDrugImportProcessor extends ImportProcessor
{
    public static function expectedHeaders(): array
    {
        return ['pharmacy_name', 'drug_trade_name', 'price'];
    }

    protected function rules(array $row, int $rowIndex): array
    {
        return [
            'pharmacy_name' => ['required', 'max:255', 'exists:pharmacies,name'],
            'drug_trade_name' => ['required', 'max:255', 'exists:drugs,trade_name'],
            'price' => ['required', 'decimal:2'],
        ];
    }

    protected function process(array $row, int $rowIndex): void
    {
        $pharmacy = Pharmacy::where('name', $row['pharmacy_name'])->first();
        $drug = Drug::where('trade_name', $row['drug_trade_name'])->first();

        PharmacyDrug::firstOrCreate([
            'pharmacy_id' => $pharmacy->id,
            'drug_id' => $drug->id,
        ], [
            'pharmacy_id' => $pharmacy->id,
            'drug_id' => $drug->id,
            'price' => $row['price'],
        ]);
    }
}
