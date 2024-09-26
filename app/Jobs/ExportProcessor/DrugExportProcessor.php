<?php

namespace App\Jobs\ExportProcessor;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class DrugExportProcessor extends BaseExportProcessor
{
    public function query(): Builder
    {
        $query =  DB::query()->from('drugs')
            ->join('drug_manufacturers', 'drugs.drug_manufacturer_id', '=', 'drug_manufacturers.id')
            ->select(
                'drugs.id',
                'drug_manufacturers.name as drug_manufacturer',
                'drugs.trade_name'
            );

        if (isset($this->filters['drug_manufacturer_id'])) {
            $query->where('drug_manufacturer_id', $this->filters['drug_manufacturer_id']);
        }

        return $query;
    }
}
