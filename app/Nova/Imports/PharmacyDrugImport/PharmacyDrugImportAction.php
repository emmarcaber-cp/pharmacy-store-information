<?php

namespace App\Nova\Imports\PharmacyDrugImport;

use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;
use App\Nova\Imports\PharmacyDrugImport\PharmacyDrugImportProcessor;

class PharmacyDrugImportAction extends ImportNovaAction
{
   // A sample processor will be shown below
    public string $processor = PharmacyDrugImportProcessor::class;
}
    