<?php

namespace App\Nova\Imports\ScheduleImport;

use App\Models\Employee;
use App\Models\Pharmacy;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;
use Coreproc\NovaDataSync\Import\Jobs\ImportProcessor;

class ScheduleImportProcessor extends ImportProcessor
{
    public static function expectedHeaders(): array
    {
        return ['pharmacy_name', 'employee_name', 'shift_start', 'shift_end'];
    }

    protected function rules(array $row, int $rowIndex): array
    {
        return [
            'pharmacy_name' => ['required', 'max:255', 'exists:pharmacies,name'],
            'employee_name' => ['required', 'max:255', 'exists:employees,name'],
            'shift_start' => ['required', 'date_format:Y-m-d H:i:s'],
            'shift_end' => ['required', 'date_format:Y-m-d H:i:s'],
        ];
    }

    protected function process(array $row, int $rowIndex): void
    {
        Log::info('processing row ' . $rowIndex);

        $pharmacy = Pharmacy::where('name', $row['pharmacy_name'])->first();
        $employee = Employee::where('name', $row['employee_name'])->first();

        Schedule::firstOrCreate([
            'pharmacy_id' => $pharmacy->id,
            'employee_id' => $employee->id,
            'shift_start' => $row['shift_start'],
            'shift_end' => $row['shift_end'],
        ], [
            'pharmacy_id' => $pharmacy->id,
            'employee_id' => $employee->id,
            'shift_start' => $row['shift_start'],
            'shift_end' => $row['shift_end'],
        ]);
    }

    public static function chunkSize(): int
    {
        return 100;
    }
}
