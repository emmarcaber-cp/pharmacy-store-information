<?php

namespace App\Nova\Imports\PatientImport;

use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;
use App\Nova\Imports\PatientImport\PatientImportProcessor;

class PatientImportAction extends ImportNovaAction
{
   // A sample processor will be shown below
    public string $processor = PatientImportProcessor::class;
}
    