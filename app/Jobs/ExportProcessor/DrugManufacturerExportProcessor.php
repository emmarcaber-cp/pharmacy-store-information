<?php

namespace App\Jobs\ExportProcessor;

use App\Models\DrugManufacturer;
use Illuminate\Contracts\Database\Query\Builder;

class DrugManufacturerExportProcessor extends BaseExportProcessor
{
    public function query(): Builder
    {
        return DrugManufacturer::query();
    }
}
