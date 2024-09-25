<?php

namespace App\Nova\Actions\Imports;

use App\Jobs\ImportProcessor\DrugManufacturerImportProcessor;
use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;

class DrugManufacturerImportAction extends ImportNovaAction
{
    // A sample processor will be shown below
    public string $processor = DrugManufacturerImportProcessor::class;
}
