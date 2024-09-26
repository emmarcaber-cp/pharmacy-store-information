<?php

namespace App\Nova\Actions\Exports;

use Laravel\Nova\Fields\Select;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Jobs\ExportProcessor\PatientExportProcessor;
use App\Types\SexTypes;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;

class PatientExportAction extends BaseExportAction
{
    protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new PatientExportProcessor($fields->toArray());
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('Doctor', 'doctor_id')
                ->options(
                    DB::table('doctors')
                        ->join('patients', 'doctors.id', '=', 'patients.doctor_id')
                        ->select('doctors.id', 'doctors.name')
                        ->distinct()
                        ->orderBy('doctors.name')
                        ->get()
                        ->pluck('name', 'id')
                        ->toArray()
                )
                ->displayUsingLabels(),

            Select::make('Sex')
                ->options(SexTypes::toArray())
                ->displayUsingLabels(),
        ];
    }
}
