<?php

namespace App\Nova\Actions\Exports;

use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use App\Jobs\ExportProcessor\DoctorExportProcessor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Coreproc\NovaDataSync\Export\Nova\Action\ExportNovaAction;

class DoctorExportAction extends ExportNovaAction
{
    protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new DoctorExportProcessor();
    }
}
