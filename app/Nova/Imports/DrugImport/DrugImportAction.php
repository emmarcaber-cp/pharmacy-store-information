<?php

namespace App\Nova\Imports\DrugImport;

use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;
use App\Nova\Imports\DrugImport\DrugImportProcessor;

class DrugImportAction extends ImportNovaAction
{
   // A sample processor will be shown below
    public string $processor = DrugImportProcessor::class;
}
    