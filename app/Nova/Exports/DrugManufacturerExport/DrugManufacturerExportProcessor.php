<?php

namespace App\Nova\Exports\DrugManufacturerExport;

use App\Models\DrugManufacturer;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Illuminate\Contracts\Database\Query\Builder;

class DrugManufacturerExportProcessor extends ExportProcessor
{
    public function query(): Builder
    {
        return DrugManufacturer::query();
    }
}