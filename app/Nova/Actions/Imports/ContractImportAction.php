<?php

namespace App\Nova\Actions\Imports;

use App\Jobs\ImportProcessor\ContractImportProcessor;
use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;

class ContractImportAction extends ImportNovaAction
{
    public string $processor = ContractImportProcessor::class;
}
