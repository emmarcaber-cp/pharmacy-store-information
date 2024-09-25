<?php

namespace App\Jobs\ExportProcessor;

use App\Models\Pharmacy;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Illuminate\Contracts\Database\Query\Builder;

class PharmacyExportProcessor extends ExportProcessor
{
    public function query(): Builder
    {
        return Pharmacy::query();
    }
}
