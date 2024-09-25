<?php

namespace App\Nova\Actions\Imports;

use App\Jobs\ImportProcessor\PatientImportProcessor;
use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;

class PatientImportAction extends ImportNovaAction
{
    public string $processor = PatientImportProcessor::class;
}
