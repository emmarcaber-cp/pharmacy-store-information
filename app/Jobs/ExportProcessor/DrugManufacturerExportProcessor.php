<?php

namespace App\Jobs\ExportProcessor;

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
