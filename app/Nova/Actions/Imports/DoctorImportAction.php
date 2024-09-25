<?php

namespace App\Nova\Actions\Imports;

use App\Jobs\ImportProcessor\DoctorImportProcessor;
use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;

class DoctorImportAction extends ImportNovaAction
{
    public string $processor = DoctorImportProcessor::class;
}
