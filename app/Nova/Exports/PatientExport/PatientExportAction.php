<?php

namespace App\Nova\Exports\PatientExport;

use Laravel\Nova\Fields\ActionFields;
use Illuminate\Support\Collection;
use App\Nova\Exports\PatientExport\PatientExportProcessor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Coreproc\NovaDataSync\Export\Nova\Action\ExportNovaAction;

class PatientExportAction extends ExportNovaAction
{
    protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new PatientExportProcessor();
    }
}
