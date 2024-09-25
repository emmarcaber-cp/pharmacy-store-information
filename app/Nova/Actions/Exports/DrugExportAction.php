<?php

namespace App\Nova\Actions\Exports;

use Laravel\Nova\Fields\Select;
use App\Models\DrugManufacturer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Jobs\ExportProcessor\DrugExportProcessor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Coreproc\NovaDataSync\Export\Nova\Action\ExportNovaAction;

class DrugExportAction extends ExportNovaAction
{
    protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new DrugExportProcessor([
            'drug_manufacturer_id' => $fields->drug_manufacturer_id,
        ]);
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('Drug Manufacturer', 'drug_manufacturer_id')
                ->options(
                    DB::table('drug_manufacturers')
                        ->join('drugs', 'drug_manufacturers.id', '=', 'drugs.drug_manufacturer_id')
                        ->select('drug_manufacturers.id', 'drug_manufacturers.name')
                        ->distinct()
                        ->orderBy('drug_manufacturers.name')
                        ->get()
                        ->pluck('name', 'id')
                        ->toArray()
                )
                ->displayUsingLabels(),
        ];
    }
}
