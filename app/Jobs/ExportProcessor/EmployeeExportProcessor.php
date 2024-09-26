<?php

namespace App\Jobs\ExportProcessor;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class EmployeeExportProcessor extends BaseExportProcessor
{
    public function query(): Builder
    {
        $query = DB::query()->from('employees')
            ->join('pharmacies', 'employees.pharmacy_id', '=', 'pharmacies.id')
            ->select(
                'employees.id',
                'pharmacies.name as pharmacy',
                'employees.name as employee',
            );

        if (isset($this->filters['pharmacy_id'])) {
            $query->where('pharmacy_id', $this->filters['pharmacy_id']);
        }

        return $query;
    }
}
