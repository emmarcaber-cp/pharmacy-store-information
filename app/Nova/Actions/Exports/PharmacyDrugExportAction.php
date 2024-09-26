<?php

namespace App\Nova\Actions\Exports;

use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Currency;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use App\Jobs\ExportProcessor\PharmacyDrugExportProcessor;

class PharmacyDrugExportAction extends BaseExportAction
{
    protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new PharmacyDrugExportProcessor($fields->toArray());
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('Pharmacy', 'pharmacy_id')
                ->options(
                    DB::table('pharmacies')
                        ->join('pharmacy_drugs', 'pharmacies.id', '=', 'pharmacy_drugs.pharmacy_id')
                        ->select('pharmacies.id', 'pharmacies.name')
                        ->distinct()
                        ->orderBy('pharmacies.name')
                        ->get()
                        ->pluck('name', 'id')
                        ->toArray()
                )
                ->displayUsingLabels(),

            Select::make('Drug', 'drug_id')
                ->options(
                    DB::table('drugs')
                        ->join('pharmacy_drugs', 'drugs.id', '=', 'pharmacy_drugs.drug_id')
                        ->select('drugs.id', 'drugs.trade_name')
                        ->distinct()
                        ->orderBy('drugs.trade_name')
                        ->get()
                        ->pluck('trade_name', 'id')
                        ->toArray()
                )
                ->displayUsingLabels(),

            Currency::make('From Price', 'price_from')
                ->displayUsing(function ($value) {
                    return $value ? number_format($value, 2) : null;
                })
                ->placeholder('MIN')
                ->rules(
                    'required',
                    'lte:price_to'
                ),

            Currency::make('To Price', 'price_to')
                ->displayUsing(function ($value) {
                    return $value ? number_format($value, 2) : null;
                })
                ->placeholder('MAX')
                ->rules(
                    'required',
                    'gte:price_from'
                )
        ];
    }
}
