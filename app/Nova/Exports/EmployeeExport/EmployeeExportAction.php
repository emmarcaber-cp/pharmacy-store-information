<?php

namespace App\Nova\Exports\EmployeeExport;

use Laravel\Nova\Fields\ActionFields;
use Illuminate\Support\Collection;
use App\Nova\Exports\EmployeeExport\EmployeeExportProcessor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Coreproc\NovaDataSync\Export\Nova\Action\ExportNovaAction;

class EmployeeExportAction extends ExportNovaAction
{
   protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new EmployeeExportProcessor();
    }
}