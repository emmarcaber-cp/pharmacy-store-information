<?php

namespace App\Nova\Actions\Exports;

use Laravel\Nova\Fields\Select;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Jobs\ExportProcessor\ContractExportProcessor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Coreproc\NovaDataSync\Export\Nova\Action\ExportNovaAction;
use Laravel\Nova\Fields\Date;

class ContractExportAction extends ExportNovaAction
{
    protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new ContractExportProcessor([
            'pharmacy_id' => $fields->pharmacy_id,
            'drug_manufacturer_id' => $fields->drug_manufacturer_id,
            'start_date_from' => $fields->start_date_from,
            'start_date_until' => $fields->start_date_until,
        ]);
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('Pharmacy', 'pharmacy_id')
                ->options(
                    DB::table('pharmacies')
                        ->join('contracts', 'pharmacies.id', '=', 'contracts.pharmacy_id')
                        ->select('pharmacies.id', 'pharmacies.name')
                        ->distinct()
                        ->orderBy('pharmacies.name')
                        ->get()
                        ->pluck('name', 'id')
                        ->toArray()
                )
                ->displayUsingLabels(),

            Select::make('Drug Manufacturer', 'drug_manufacturer_id')
                ->options(
                    DB::table('drug_manufacturers')
                        ->join('contracts', 'drug_manufacturers.id', '=', 'contracts.drug_manufacturer_id')
                        ->select('drug_manufacturers.id', 'drug_manufacturers.name')
                        ->distinct()
                        ->orderBy('drug_manufacturers.name')
                        ->get()
                        ->pluck('name', 'id')
                        ->toArray()
                )
                ->displayUsingLabels(),

            Date::make('Start Date - FROM', 'start_date_from'),

            Date::make('Start Date - UNTIL', 'start_date_until')
        ];
    }
}
