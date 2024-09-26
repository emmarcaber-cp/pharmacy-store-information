<?php

namespace App\Nova\Actions\Exports;

use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use App\Jobs\ExportProcessor\DrugManufacturerExportProcessor;

class DrugManufacturerExportAction extends BaseExportAction
{
    protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new DrugManufacturerExportProcessor();
    }
}
