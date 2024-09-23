<?php

namespace App\Nova\Imports\DoctorImport;

use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;
use App\Nova\Imports\DoctorImport\DoctorImportProcessor;

class DoctorImportAction extends ImportNovaAction
{
   // A sample processor will be shown below
    public string $processor = DoctorImportProcessor::class;
}
    