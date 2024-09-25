<?php

namespace App\Jobs\ExportProcessor;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class PatientExportProcessor extends BaseExportProcessor
{
    public function query(): Builder
    {
        $query = DB::query()->from('patients')
            ->join('doctors', 'patients.doctor_id', '=', 'doctors.id')
            ->select(
                'patients.id',
                'doctors.name as doctor',
                'patients.name as patient',
                'patients.sex',
                'patients.address',
                'patients.contact_no as contact_number'
            );

        if ($this->filters['doctor_id'] ?? false) {
            $query->where('doctor_id', $this->filters['doctor_id']);
        }

        if ($this->filters['sex'] ?? false) {
            $query->where('sex', $this->filters['sex']);
        }

        return $query;
    }
}
