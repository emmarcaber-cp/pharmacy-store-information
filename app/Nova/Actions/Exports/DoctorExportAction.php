<?php

namespace App\Nova\Actions\Exports;

use App\Models\Doctor;
use Laravel\Nova\Fields\Select;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Jobs\ExportProcessor\DoctorExportProcessor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Coreproc\NovaDataSync\Export\Nova\Action\ExportNovaAction;

class DoctorExportAction extends ExportNovaAction
{
    protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new DoctorExportProcessor([
            'specialty' => $fields->specialty,
        ]);
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
