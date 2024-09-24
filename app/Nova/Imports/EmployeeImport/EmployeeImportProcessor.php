<?php

namespace App\Nova\Imports\EmployeeImport;

use App\Models\Employee;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\Log;
use Coreproc\NovaDataSync\Import\Jobs\ImportProcessor;

class EmployeeImportProcessor extends ImportProcessor
{
    public static function expectedHeaders(): array
    {
        return ['name', 'pharmacy_name'];
    }

    protected function rules(array $row, int $rowIndex): array
    {
        return [
            'name' => ['required', 'max:255'],
            'pharmacy_name' => ['required', 'max:255', 'exists:pharmacies,name'],
        ];
    }

    protected function process(array $row, int $rowIndex): void
    {
        Log::info('processing row ' . $rowIndex);

        $pharmacy = Pharmacy::where('name', $row['pharmacy_name'])->first();

        Employee::firstOrCreate(
            ['name' => $row['name']],
            ['pharmacy_id' => $pharmacy->id]
        );
    }

    public static function chunkSize(): int
    {
        return 100;
    }
}
