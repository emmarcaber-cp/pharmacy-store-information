<?php

namespace App\Nova;

use App\Nova\PharmacyDrug;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasManyThrough;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Exports\DrugExport\DrugExportAction;
use App\Nova\Imports\DrugImport\DrugImportAction;

class Drug extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Drug>
     */
    public static $model = \App\Models\Drug::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'trade_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'trade_name',
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

            BelongsTo::make('Drug Manufacturer', 'drugManufacturer', DrugManufacturer::class),

            Text::make('Trade Name')
                ->sortable()
                ->rules('required', 'max:255'),

            BelongsToMany::make('Pharmacy', 'pharmacies', Pharmacy::class),
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
            new DrugImportAction(),
            new DrugExportAction(),
        ];
    }
}
