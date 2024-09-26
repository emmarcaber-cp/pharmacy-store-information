<?php

namespace App\Nova\Actions\Exports;

use Laravel\Nova\Fields\Select;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Jobs\ExportProcessor\DoctorExportProcessor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;

class DoctorExportAction extends BaseExportAction
{
    protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new DoctorExportProcessor($fields->toArray());
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('Specialty')
                ->options(
                    DB::table('doctors')
                        ->distinct()
                        ->select('specialty')
                        ->get()
                        ->pluck('specialty', 'specialty')
                        ->toArray()
                )
                ->displayUsingLabels(),
        ];
    }
}
