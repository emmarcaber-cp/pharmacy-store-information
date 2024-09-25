<?php

namespace App\Nova\Actions\Imports;

use App\Jobs\ImportProcessor\ScheduleImportProcessor;
use Coreproc\NovaDataSync\Import\Nova\Actions\ImportNovaAction;

class ScheduleImportAction extends ImportNovaAction
{
    public string $processor = ScheduleImportProcessor::class;
}
