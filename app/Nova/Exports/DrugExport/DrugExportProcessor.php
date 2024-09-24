<?php

namespace App\Nova\Exports\DrugExport;

use App\Models\Drug;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Illuminate\Contracts\Database\Query\Builder;

class DrugExportProcessor extends ExportProcessor
{
    public function query(): Builder
    {
        return Drug::query();
    }
}