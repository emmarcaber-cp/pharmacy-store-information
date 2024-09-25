<?php

namespace App\Jobs\ExportProcessor;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ScheduleExportProcessor extends BaseExportProcessor
{
    public function query(): Builder
    {
        $query =  DB::query()->from('schedules')
            ->join('employees', 'schedules.employee_id', '=', 'employees.id')
            ->join('pharmacies', 'schedules.pharmacy_id', '=', 'pharmacies.id')
            ->select(
                'schedules.id',
                'employees.name as employee',
                'pharmacies.name as pharmacy',
                'schedules.shift_start',
                'schedules.shift_end',
            );

        if ($this->filters['employee_id'] ?? false) {
            $query->where('employee_id', $this->filters['employee_id']);
        }

        if ($this->filters['pharmacy_id'] ?? false) {
            $query->where('pharmacy_id', $this->filters['pharmacy_id']);
        }

        if ($this->filters['shift_start_from'] ?? false && $this->filters['shift_start_until'] ?? false) {
            $query->whereBetween('shift_start', [
                $this->filters['shift_start_from'],
                $this->filters['shift_start_until'],
            ]);
        }

        return $query;
    }
}
