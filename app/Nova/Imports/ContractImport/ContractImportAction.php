<?php

namespace App\Nova\Imports\ContractImport;

use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;
use App\Nova\Imports\ContractImport\ContractImportProcessor;

class ContractImportAction extends ImportNovaAction
{
   // A sample processor will be shown below
    public string $processor = ContractImportProcessor::class;
}
    