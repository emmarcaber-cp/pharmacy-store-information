<?php

namespace App\Nova\Exports\PatientExport;

use App\Models\Patient;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Illuminate\Contracts\Database\Query\Builder;

class PatientExportProcessor extends ExportProcessor
{
    public function query(): Builder
    {
        return Patient::query();
    }
}