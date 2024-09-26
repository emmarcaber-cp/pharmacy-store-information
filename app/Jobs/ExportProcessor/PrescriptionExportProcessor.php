<?php

namespace App\Jobs\ExportProcessor;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class PrescriptionExportProcessor extends BaseExportProcessor
{
    public function query(): Builder
    {
        $query = DB::query()->from('prescriptions')
            ->join('doctors', 'prescriptions.doctor_id', '=', 'doctors.id')
            ->join('patients', 'prescriptions.patient_id', '=', 'patients.id')
            ->join('drugs', 'prescriptions.drug_id', '=', 'drugs.id')
            ->select(
                'prescriptions.id',
                'doctors.name as doctor',
                'patients.name as patient',
                'drugs.trade_name as drug',
                'prescriptions.quantity',
                'prescriptions.prescribed_at',
            );

        if (isset($this->filters['doctor_id'])) {
            $query->where('doctor_id', $this->filters['doctor_id']);
        }

        if (isset($this->filters['patient_id'])) {
            $query->where('patient_id', $this->filters['patient_id']);
        }

        if (isset($this->filters['drug_id'])) {
            $query->where('drug_id', $this->filters['drug_id']);
        }

        if (isset($this->filters['quantity_from'])) {
            $query->where('quantity', '>=', $this->filters['quantity_from']);
        }

        if (isset($this->filters['quantity_to'])) {
            $query->where('quantity', '<=', $this->filters['quantity_to']);
        }

        if (isset($this->filters['prescribed_at_from'])) {
            $query->where('prescribed_at', '>=', $this->filters['prescribed_at_from']);
        }

        if (isset($this->filters['prescribed_at_to'])) {
            $query->where('prescribed_at', '<=', $this->filters['prescribed_at_to']);
        }

        return $query;
    }
}
