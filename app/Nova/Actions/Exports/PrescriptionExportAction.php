<?php

namespace App\Nova\Actions\Exports;

use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use App\Jobs\ExportProcessor\PrescriptionExportProcessor;
use Coreproc\NovaDataSync\Export\Nova\Action\ExportNovaAction;

class PrescriptionExportAction extends ExportNovaAction
{
    protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new PrescriptionExportProcessor([
            'doctor_id' => $fields->doctor_id,
            'patient_id' => $fields->patient_id,
            'drug_id' => $fields->drug_id,
            'quantity_from' => $fields->quantity_from,
            'quantity_to' => $fields->quantity_to,
            'prescribed_at_from' => $fields->prescribed_at_from,
            'prescribed_at_until' => $fields->prescribed_at_until,
        ]);
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

            Number::make('Quantity - FROM', 'quantity_from')
                ->placeholder('MIN'),

            Number::make('Quantity - TO', 'quantity_to')
                ->placeholder('MAX')
                ->rules('required_with:quantity_from', 'gte:quantity_from'),

            Date::make('Prescribed at - FROM', 'prescribed_at_from'),

            Date::make('Prescribed at - UNTIL', 'prescribed_at_until')
        ];
    }
}
