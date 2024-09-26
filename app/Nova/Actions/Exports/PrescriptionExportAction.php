<?php

namespace App\Nova\Actions\Exports;

use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\FormData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use App\Jobs\ExportProcessor\PrescriptionExportProcessor;

class PrescriptionExportAction extends BaseExportAction
{
    protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new PrescriptionExportProcessor($fields->toArray());
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('Doctor', 'doctor_id')
                ->options(
                    DB::table('doctors')
                        ->join('prescriptions', 'doctors.id', '=', 'prescriptions.doctor_id')
                        ->select('doctors.id', 'doctors.name')
                        ->distinct()
                        ->orderBy('doctors.name')
                        ->get()
                        ->pluck('name', 'id')
                        ->toArray()
                )
                ->displayUsingLabels(),

            Select::make('Patient', 'patient_id')
                ->options(
                    DB::table('patients')
                        ->join('prescriptions', 'patients.id', '=', 'prescriptions.patient_id')
                        ->select('patients.id', 'patients.name')
                        ->distinct()
                        ->orderBy('patients.name')
                        ->get()
                        ->pluck('name', 'id')
                        ->toArray()
                )
                ->displayUsingLabels(),

            Select::make('Drug', 'drug_id')
                ->options(
                    DB::table('drugs')
                        ->join('prescriptions', 'drugs.id', '=', 'prescriptions.drug_id')
                        ->select('drugs.id', 'drugs.trade_name')
                        ->distinct()
                        ->orderBy('drugs.trade_name')
                        ->get()
                        ->pluck('trade_name', 'id')
                        ->toArray()
                )
                ->displayUsingLabels(),

            Number::make('From Quantity', 'quantity_from')
                ->placeholder('MIN')
                ->rules(
                    'required',
                    'numeric',
                    'lte:quantity_to'
                ),

            Number::make('To Quantity', 'quantity_to')
                ->placeholder('MAX')
                ->rules(
                    'required',
                    'numeric',
                    'gte:quantity_from'
                ),

            Date::make('From Prescribed at', 'prescribed_at_from')
                ->rules(
                    'required',
                    'date',
                    'before_or_equal:prescribed_at_to'
                ),

            Date::make('To Prescribed at', 'prescribed_at_to')
                ->rules(
                    'required',
                    'date',
                    'after_or_equal:prescribed_at_from'
                ),
        ];
    }
}
