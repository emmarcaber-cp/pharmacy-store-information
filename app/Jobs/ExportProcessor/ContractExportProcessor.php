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

        if (isset($this->filters['pharmacy_id'])) {
            $query->where('pharmacy_id', $this->filters['pharmacy_id']);
        }

        if (isset($this->filters['drug_manufacturer_id'])) {
            $query->where('drug_manufacturer_id', $this->filters['drug_manufacturer_id']);
        }

        if (isset($this->filters['start_date_from'])) {
            $query->where('start_date', '>=', $this->filters['start_date_from']);
        }

        if (isset($this->filters['start_date_to'])) {
            $query->where('start_date', '<=', $this->filters['start_date_to']);
        }

        return $query;
    }
}
