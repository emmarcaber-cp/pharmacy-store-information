<?php

namespace App\Nova\Actions\Imports;

use App\Jobs\ImportProcessor\PrescriptionImportProcessor;
use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;

class PrescriptionImportAction extends ImportNovaAction
{
    public string $processor = PrescriptionImportProcessor::class;
}
