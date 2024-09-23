<?php

namespace App\Nova\Imports\PharmacyImport;

use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;
use App\Nova\Imports\PharmacyImport\PharmacyImportProcessor;

class PharmacyImportAction extends ImportNovaAction
{
   // A sample processor will be shown below
    public string $processor = PharmacyImportProcessor::class;
}
    