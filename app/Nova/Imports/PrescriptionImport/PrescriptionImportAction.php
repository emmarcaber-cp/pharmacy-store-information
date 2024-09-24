<?php

namespace App\Nova\Imports\PrescriptionImport;

use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;
use App\Nova\Imports\PrescriptionImport\PrescriptionImportProcessor;

class PrescriptionImportAction extends ImportNovaAction
{
   // A sample processor will be shown below
    public string $processor = PrescriptionImportProcessor::class;
}
    