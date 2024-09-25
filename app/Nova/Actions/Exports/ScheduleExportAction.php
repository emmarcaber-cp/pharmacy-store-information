<?php

namespace App\Nova\Actions\Exports;

use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use App\Jobs\ExportProcessor\ScheduleExportProcessor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Coreproc\NovaDataSync\Export\Nova\Action\ExportNovaAction;

class ScheduleExportAction extends ExportNovaAction
{
    protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new ScheduleExportProcessor();
    }
}
