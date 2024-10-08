<?php

namespace App\Jobs\ImportProcessor;

use App\Models\Employee;
use App\Models\Pharmacy;
use App\Models\Schedule;
use App\Exceptions\SaveRecordException;
use Coreproc\NovaDataSync\Import\Jobs\ImportProcessor;

class ScheduleImportProcessor extends ImportProcessor
{
    public static function expectedHeaders(): array
    {
        return [
            'pharmacy_name',
            'employee_name',
            'shift_start',
            'shift_end'
        ];
    }

    protected function rules(array $row, int $rowIndex): array
    {
        return [
            'pharmacy_name' => [
                'required',
                'max:255',
                'exists:pharmacies,name'
            ],
            'employee_name' => [
                'required',
                'max:255',
                'exists:employees,name'
            ],
            'shift_start' => [
                'required',
            ],
            'shift_end' => [
                'required',
            ],
        ];
    }

    protected function process(array $row, int $rowIndex): void
    {
        $pharmacy = Pharmacy::where('name', $row['pharmacy_name'])->first();
        $employee = Employee::where('name', $row['employee_name'])->first();

        $schedule = Schedule::firstOrNew([
            'pharmacy_id' => $pharmacy->id,
            'employee_id' => $employee->id,
            'shift_start' => $row['shift_start'],
            'shift_end' => $row['shift_end'],
        ]);

        throw_if(
            $schedule->save() === false,
            new SaveRecordException($schedule)
        );
    }
}
