<?php

namespace App\Nova\Imports\ScheduleImport;

use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;
use App\Nova\Imports\ScheduleImport\ScheduleImportProcessor;

class ScheduleImportAction extends ImportNovaAction
{
   // A sample processor will be shown below
    public string $processor = ScheduleImportProcessor::class;
}
    