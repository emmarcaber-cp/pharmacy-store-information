<?php

namespace App\Nova\Exports\DoctorExport;

use Laravel\Nova\Fields\ActionFields;
use Illuminate\Support\Collection;
use App\Nova\Exports\DoctorExport\DoctorExportProcessor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Coreproc\NovaDataSync\Export\Nova\Action\ExportNovaAction;

class DoctorExportAction extends ExportNovaAction
{
   protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new DoctorExportProcessor();
    }
}