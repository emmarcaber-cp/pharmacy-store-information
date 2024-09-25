<?php

namespace App\Nova\Actions\Exports;

use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use App\Jobs\ExportProcessor\PharmacyDrugExportProcessor;
use Coreproc\NovaDataSync\Export\Nova\Action\ExportNovaAction;

class PharmacyDrugExportAction extends ExportNovaAction
{
    protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new PharmacyDrugExportProcessor();
    }
}
