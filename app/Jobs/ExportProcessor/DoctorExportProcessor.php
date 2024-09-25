<?php

namespace App\Jobs\ExportProcessor;

use App\Models\Doctor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Illuminate\Contracts\Database\Query\Builder;

class DoctorExportProcessor extends ExportProcessor
{
    public function query(): Builder
    {
        return Doctor::query();
    }
}
