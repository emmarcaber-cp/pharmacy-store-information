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

        if ($this->filters['pharmacy_id'] ?? false) {
            $query->where('pharmacy_id', $this->filters['pharmacy_id']);
        }

        if ($this->filters['drug_id'] ?? false) {
            $query->where('drug_id', $this->filters['drug_id']);
        }

        if ($this->filters['price_from'] ?? false && $this->filters['price_to'] ?? false) {
            $query->where('price', '>=', $this->filters['price_from'])
                ->where('price', '<=', $this->filters['price_to']);
        }

        return $query;
    }
}
