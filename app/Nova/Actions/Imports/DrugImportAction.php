<?php

namespace App\Nova\Actions\Imports;

use App\Jobs\ImportProcessor\DrugImportProcessor;
use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;

class DrugImportAction extends ImportNovaAction
{
    public string $processor = DrugImportProcessor::class;
}
