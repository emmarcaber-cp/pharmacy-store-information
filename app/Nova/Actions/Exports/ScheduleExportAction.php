<?php

namespace App\Nova\Actions\Exports;

use Laravel\Nova\Fields\Select;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Jobs\ExportProcessor\ScheduleExportProcessor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Coreproc\NovaDataSync\Export\Nova\Action\ExportNovaAction;
use Laravel\Nova\Fields\Date;

class ScheduleExportAction extends ExportNovaAction
{
    protected function processor(ActionFields $fields, Collection $models): ExportProcessor
    {
        return new ScheduleExportProcessor([
            'employee_id' => $fields->employee_id,
            'pharmacy_id' => $fields->pharmacy_id,
            'shift_start_from' => $fields->shift_start_from,
            'shift_start_until' => $fields->shift_start_until,
        ]);
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('Employee', 'employee_id')
                ->options(
                    DB::table('employees')
                        ->join('schedules', 'employees.id', '=', 'schedules.employee_id')
                        ->select('employees.id', 'employees.name')
                        ->distinct()
                        ->orderBy('employees.name')
                        ->get()
                        ->pluck('name', 'id')
                        ->toArray()
                )
                ->displayUsingLabels(),

            Select::make('Pharmacy', 'pharmacy_id')
                ->options(
                    DB::table('pharmacies')
                        ->join('schedules', 'pharmacies.id', '=', 'schedules.pharmacy_id')
                        ->select('pharmacies.id', 'pharmacies.name')
                        ->distinct()
                        ->orderBy('pharmacies.name')
                        ->get()
                        ->pluck('name', 'id')
                        ->toArray()
                )
                ->displayUsingLabels(),

            Date::make('Shift Start - FROM', 'shift_start_from'),

            Date::make('Shift Start - UNTIL', 'shift_start_until'),
        ];
    }
}
