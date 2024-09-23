<?php

namespace App\Nova\Imports\DrugManufacturerImport;

use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;
use App\Nova\Imports\DrugManufacturerImport\DrugManufacturerImportProcessor;

class DrugManufacturerImportAction extends ImportNovaAction
{
   // A sample processor will be shown below
    public string $processor = DrugManufacturerImportProcessor::class;
}
    