<?php

namespace App\Nova\Actions\Imports;

use App\Jobs\ImportProcessor\EmployeeImportProcessor;
use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;

class EmployeeImportAction extends ImportNovaAction
{
    public string $processor = EmployeeImportProcessor::class;
}
