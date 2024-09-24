<?php

namespace App\Nova\Exports\PrescriptionExport;

use Laravel\Nova\Fields\ActionFields;
use Illuminate\Support\Collection;
use App\Nova\Exports\PrescriptionExport\PrescriptionExportProcessor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Coreproc\NovaDataSync\Export\Nova\Action\ExportNovaAction;

class PrescriptionExportAction extends ExportNovaAction
{
   protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new PrescriptionExportProcessor();
    }
}