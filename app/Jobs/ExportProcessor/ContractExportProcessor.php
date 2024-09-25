<?php

namespace App\Jobs\ExportProcessor;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Query\Builder;

class ContractExportProcessor extends BaseExportProcessor
{
    public function query(): Builder
    {
        $query = DB::query()->from('contracts')
            ->join('pharmacies', 'contracts.pharmacy_id', '=', 'pharmacies.id')
            ->join('drug_manufacturers', 'contracts.drug_manufacturer_id', '=', 'drug_manufacturers.id')
            ->select(
                'contracts.id',
                'pharmacies.name as pharmacy',
                'drug_manufacturers.name as drug_manufacturer',
                'start_date',
                'end_date'
            );

        if ($this->filters['pharmacy_id'] ?? false) {
            $query->where('pharmacy_id', $this->filters['pharmacy_id']);
        }

        if ($this->filters['drug_manufacturer_id'] ?? false) {
            $query->where('drug_manufacturer_id', $this->filters['drug_manufacturer_id']);
        }

        if ($this->filters['start_date_from'] ?? false && $this->filters['start_date_until'] ?? false) {
            $query->whereBetween('start_date', [
                $this->filters['start_date_from'],
                $this->filters['start_date_until'],
            ]);
        }

        return $query;
    }
}
