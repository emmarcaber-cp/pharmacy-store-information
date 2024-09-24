<?php

namespace App\Nova\Exports\PharmacyDrugExport;

use App\Models\PharmacyDrug;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Illuminate\Contracts\Database\Query\Builder;

class PharmacyDrugExportProcessor extends ExportProcessor
{
    public function query(): Builder
    {
        return PharmacyDrug::query();
    }
}