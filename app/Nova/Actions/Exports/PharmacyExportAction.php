<?php

namespace App\Nova\Actions\Exports;

use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use App\Jobs\ExportProcessor\PharmacyExportProcessor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;

class PharmacyExportAction extends BaseExportAction
{
    protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new PharmacyExportProcessor();
    }
}
