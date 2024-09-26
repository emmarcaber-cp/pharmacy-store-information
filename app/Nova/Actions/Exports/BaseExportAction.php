<?php

namespace App\Nova\Actions\Exports;

use Coreproc\NovaDataSync\Export\Nova\Action\ExportNovaAction;

abstract class BaseExportAction extends ExportNovaAction
{
    public function __construct()
    {
        $this->onlyOnIndex();
    }
}
