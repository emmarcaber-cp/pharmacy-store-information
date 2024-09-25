<?php

namespace App\Jobs\ImportProcessor;

use App\Models\Employee;
use App\Models\Pharmacy;
use App\Exceptions\SaveRecordException;
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
        $pharmacy = Pharmacy::where(
            'name',
            trim($row['pharmacy_name'])
        )->first();

        $employee = Employee::firstOrNew([
            'name' => $row['name'],
            'pharmacy_id' => $pharmacy->id
        ]);

        throw_if(
            $employee->save() === false,
            new SaveRecordException($employee)
        );
    }
}
