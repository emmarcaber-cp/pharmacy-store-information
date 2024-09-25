<?php

namespace App\Nova\Actions\Imports;

use App\Jobs\ImportProcessor\PharmacyImportProcessor;
use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;

class PharmacyImportAction extends ImportNovaAction
{
    public string $processor = PharmacyImportProcessor::class;
}
