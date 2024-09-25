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

        if ($this->filters['doctor_id'] ?? false) {
            $query->where('doctor_id', $this->filters['doctor_id']);
        }

        if ($this->filters['patient_id'] ?? false) {
            $query->where('patient_id', $this->filters['patient_id']);
        }

        if ($this->filters['drug_id'] ?? false) {
            $query->where('drug_id', $this->filters['drug_id']);
        }

        if ($this->filters['quantity_from'] ?? false && $this->filters['quantity_to'] ?? false) {
            $query->where('price', '>=', $this->filters['quantity_from'])
                ->where('price', '<=', $this->filters['quantity_to']);
        }

        if ($this->filters['prescribed_at_from'] ?? false && $this->filters['prescribed_at_until'] ?? false) {
            $query->whereBetween('prescribed_at', [
                $this->filters['prescribed_at_from'],
                $this->filters['prescribed_at_until'],
            ]);
        }

        return $query;
    }
}
