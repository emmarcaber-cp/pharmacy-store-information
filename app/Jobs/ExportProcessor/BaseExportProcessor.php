<?php

namespace App\Jobs\ExportProcessor;

use App\Models\Doctor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Illuminate\Contracts\Database\Query\Builder;

abstract class BaseExportProcessor extends ExportProcessor
{
    public function __construct(protected ?array $filters = null) {}
}
