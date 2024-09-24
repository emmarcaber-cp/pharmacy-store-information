<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Imports\PharmacyDrugImport\PharmacyDrugImportAction;
use App\Nova\Exports\PharmacyDrugExport\PharmacyDrugExportAction;

class PharmacyDrug extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\PharmacyDrug>
     */
    public static $model = \App\Models\PharmacyDrug::class;

    /**
     * Override the title method to concatenate pharmacy and drug names.
     *
     * @return string
     */
    public function title()
    {
        return "{$this->pharmacy->name} - {$this->drug->trade_name}";
    }

    public static $with = ['pharmacy', 'drug'];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'pharmacy.name',
        'drug.trade_name',
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

            BelongsTo::make('Drug', 'drug', Drug::class),

            Currency::make('Price')->sortable()->currency('PHP'),
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
            new PharmacyDrugImportAction(),
            new PharmacyDrugExportAction(),
        ];
    }
}
