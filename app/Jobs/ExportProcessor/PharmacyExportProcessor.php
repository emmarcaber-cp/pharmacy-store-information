<?php

namespace App\Jobs\ExportProcessor;

use App\Models\Pharmacy;
use Illuminate\Contracts\Database\Query\Builder;

class PharmacyExportProcessor extends BaseExportProcessor
{
    public function query(): Builder
    {
        return Pharmacy::query();
    }
}
