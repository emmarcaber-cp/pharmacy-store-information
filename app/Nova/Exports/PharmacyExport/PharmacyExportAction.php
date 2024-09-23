<?php

namespace App\Nova\Exports\PharmacyExport;

use Laravel\Nova\Fields\ActionFields;
use Illuminate\Support\Collection;
use App\Nova\Exports\PharmacyExport\PharmacyExportProcessor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Coreproc\NovaDataSync\Export\Nova\Action\ExportNovaAction;

class PharmacyExportAction extends ExportNovaAction
{
   protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new PharmacyExportProcessor();
    }
}