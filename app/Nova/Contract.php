<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Exports\ContractExport\ContractExportAction;
use App\Nova\Imports\ContractImport\ContractImportAction;

class Contract extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Contract>
     */
    public static $model = \App\Models\Contract::class;

    /**
     * Override the title method to concatenate pharmacy and drug manufacturer names.
     *
     * @return string
     */
    public function title()
    {
        return "{$this->pharmacy->name} - {$this->drugManufacturer->name}";
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'pharmacy.name',
        'drugManufacturer.name',
    ];

    public static $with = ['pharmacy', 'drugManufacturer'];

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

            BelongsTo::make('Pharmacy', 'pharmacy', Pharmacy::class),

            BelongsTo::make('Drug Manufacturer', 'drugManufacturer', DrugManufacturer::class),

            Date::make('Start Date')->sortable(),

            Date::make('End Date')->sortable()->rules('after_or_equal:start_date'),
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
            new ContractImportAction(),
            new ContractExportAction(),
        ];
    }
}
