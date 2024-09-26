<?php

namespace App\Nova\Actions\Exports;

use Laravel\Nova\Fields\Select;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Jobs\ExportProcessor\ContractExportProcessor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Laravel\Nova\Fields\Date;

class ContractExportAction extends BaseExportAction
{
    protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new ContractExportProcessor($fields->toArray());
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

            Date::make('From Start Date', 'start_date_from')
                ->rules(
                    'required',
                    'date',
                    'before_or_equal:start_date_to'
                ),

            Date::make('To Start Date', 'start_date_to')
                ->rules(
                    'required',
                    'date',
                    'after_or_equal:start_date_from'
                ),
        ];
    }
}
