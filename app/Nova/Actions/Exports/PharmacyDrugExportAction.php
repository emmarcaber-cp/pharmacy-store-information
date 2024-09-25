<?php

namespace App\Nova\Actions\Exports;

use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use App\Jobs\ExportProcessor\PharmacyDrugExportProcessor;
use Coreproc\NovaDataSync\Export\Nova\Action\ExportNovaAction;

class PharmacyDrugExportAction extends ExportNovaAction
{
    protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new PharmacyDrugExportProcessor([
            'pharmacy_id' => $fields->pharmacy_id,
            'drug_id' => $fields->drug_id,
            'price_from' => $fields->price_from,
            'price_to' => $fields->price_to,
        ]);
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

            Number::make('Price - FROM', 'price_from')
                ->placeholder('MIN'),

            Number::make('Price - TO', 'price_to')
                ->placeholder('MAX')
                ->rules('required_with:price_from', 'gte:price_from')
        ];
    }
}
