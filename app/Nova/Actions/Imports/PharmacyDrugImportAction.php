<?php

namespace App\Nova\Actions\Imports;

use App\Jobs\ImportProcessor\PharmacyDrugImportProcessor;
use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;

class PharmacyDrugImportAction extends ImportNovaAction
{
    public string $processor = PharmacyDrugImportProcessor::class;
}
