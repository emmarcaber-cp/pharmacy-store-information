<?php

namespace App\Nova\Exports\DrugManufacturerExport;

use Laravel\Nova\Fields\ActionFields;
use Illuminate\Support\Collection;
use App\Nova\Exports\DrugManufacturerExport\DrugManufacturerExportProcessor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Coreproc\NovaDataSync\Export\Nova\Action\ExportNovaAction;

class DrugManufacturerExportAction extends ExportNovaAction
{
   protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new DrugManufacturerExportProcessor();
    }
}