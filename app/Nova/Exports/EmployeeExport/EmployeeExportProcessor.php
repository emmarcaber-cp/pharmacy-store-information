<?php

namespace App\Nova\Exports\EmployeeExport;

use App\Models\Employee;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Illuminate\Contracts\Database\Query\Builder;

class EmployeeExportProcessor extends ExportProcessor
{
    public function query(): Builder
    {
        return Employee::query();
    }
}