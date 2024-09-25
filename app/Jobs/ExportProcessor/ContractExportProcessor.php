<?php

namespace App\Jobs\ExportProcessor;

use App\Models\Contract;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Illuminate\Contracts\Database\Query\Builder;

class ContractExportProcessor extends ExportProcessor
{
    public function query(): Builder
    {
        return Contract::query();
    }
}
