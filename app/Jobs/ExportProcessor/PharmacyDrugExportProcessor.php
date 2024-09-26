<?php

namespace App\Jobs\ExportProcessor;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class PharmacyDrugExportProcessor extends BaseExportProcessor
{
    public function query(): Builder
    {
        $query = DB::query()->from('pharmacy_drugs')
            ->join('pharmacies', 'pharmacy_drugs.pharmacy_id', '=', 'pharmacies.id')
            ->join('drugs', 'pharmacy_drugs.drug_id', '=', 'drugs.id')
            ->select(
                'pharmacy_drugs.id',
                'pharmacies.name as pharmacy',
                'drugs.trade_name as drug',
                'pharmacy_drugs.price'
            );

        if (isset($this->filters['pharmacy_id'])) {
            $query->where('pharmacy_id', $this->filters['pharmacy_id']);
        }

        if (isset($this->filters['drug_id'])) {
            $query->where('drug_id', $this->filters['drug_id']);
        }

        if (isset($this->filters['price_from'])) {
            $query->where('price', '>=', $this->filters['price_from']);
        }

        if (isset($this->filters['price_to'])) {
            $query->where('price', '<=', $this->filters['price_to']);
        }

        return $query;
    }
}
