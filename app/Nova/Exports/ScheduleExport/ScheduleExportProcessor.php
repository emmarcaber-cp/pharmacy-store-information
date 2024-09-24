<?php

namespace App\Nova\Exports\ScheduleExport;

use App\Models\Schedule;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Illuminate\Contracts\Database\Query\Builder;

class ScheduleExportProcessor extends ExportProcessor
{
    public function query(): Builder
    {
        return Schedule::query();
    }
}