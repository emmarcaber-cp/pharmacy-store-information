<?php

namespace App\Nova\Exports\PrescriptionExport;

use App\Models\Prescription;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Illuminate\Contracts\Database\Query\Builder;

class PrescriptionExportProcessor extends ExportProcessor
{
    public function query(): Builder
    {
        return Prescription::query();
    }
}