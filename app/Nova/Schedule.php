<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Actions\Exports\ScheduleExportAction;
use App\Nova\Actions\Imports\ScheduleImportAction;

class Schedule extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Schedule>
     */
    public static $model = \App\Models\Schedule::class;

    /**
     * Override the title method to concatenate pharmacy and drug manufacturer names.
     *
     * @return string
     */
    public function title()
    {
        return "{$this->pharmacy->name} - {$this->employee->name}";
    }

    public static $with = ['pharmacy', 'employee'];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'pharmacy.name',
        'employee.name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Pharmacy', 'pharmacy', Pharmacy::class)
                ->showCreateRelationButton(),

            BelongsTo::make('Employee', 'employee', Employee::class)
                ->showCreateRelationButton(),

            DateTime::make('Shift Start')
                ->sortable()
                ->rules('required'),

            DateTime::make('Shift End')
                ->sortable()
                ->rules('required', 'after:shift_start'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            new ScheduleImportAction(),
            new ScheduleExportAction(),
        ];
    }
}
