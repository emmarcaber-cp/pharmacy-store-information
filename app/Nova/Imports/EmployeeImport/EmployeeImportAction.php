<?php

namespace App\Nova\Imports\EmployeeImport;

use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;
use App\Nova\Imports\EmployeeImport\EmployeeImportProcessor;

class EmployeeImportAction extends ImportNovaAction
{
   // A sample processor will be shown below
    public string $processor = EmployeeImportProcessor::class;
}
    