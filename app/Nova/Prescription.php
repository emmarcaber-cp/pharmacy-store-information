<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Http\Requests\NovaRequest;

class Prescription extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Prescription>
     */
    public static $model = \App\Models\Prescription::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'doctor.name',
        'patient.name',
        'drug.trade_name',
    ];

    /**
     * Override the title method to concatenate doctor, patient and drug names.
     *
     * @return string
     */
    public function title()
    {
        return "{$this->doctor->name} - {$this->patient->name} - {$this->drug->trade_name}";
    }

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

            BelongsTo::make('Doctor', 'doctor', Doctor::class)
                ->showCreateRelationButton(),

            BelongsTo::make('Patient', 'patient', Patient::class)
                ->showCreateRelationButton(),

            BelongsTo::make('Drug', 'drug', Drug::class),

            Number::make('Quantity')->min(1)->default(1),

            Date::make('Prescribed At')->sortable()->rules('required'),
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
        return [];
    }
}
