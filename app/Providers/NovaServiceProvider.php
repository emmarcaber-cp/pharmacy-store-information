<?php

namespace App\Providers;

use App\Nova\Drug;
use App\Nova\Doctor;
use App\Nova\Patient;
use App\Nova\Contract;
use App\Nova\Employee;
use App\Nova\Pharmacy;
use App\Nova\Schedule;
use Laravel\Nova\Nova;
use App\Nova\PharmacyDrug;
use Illuminate\Http\Request;
use App\Nova\DrugManufacturer;
use App\Nova\Prescription;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Dashboards\Main;
use Laravel\Nova\Menu\MenuSection;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::withBreadcrumbs();

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::dashboard(Main::class)->icon('chart-bar'),

                MenuSection::make('Pharmacies Management', [
                    MenuItem::resource(Pharmacy::class),
                    MenuItem::resource(Employee::class),
                    MenuItem::resource(Schedule::class),
                    MenuItem::resource(PharmacyDrug::class),
                    MenuItem::resource(Contract::class),
                ])->icon('office-building')->collapsable(),

                MenuSection::make('Drugs Management', [
                    MenuItem::resource(DrugManufacturer::class),
                    MenuItem::resource(Drug::class),
                    MenuItem::resource(Contract::class),
                ])->icon('beaker')->collapsable(),

                MenuSection::make('Patients Management', [
                    MenuItem::resource(Patient::class),
                    MenuItem::resource(Doctor::class),
                    MenuItem::resource(Prescription::class),
                ])->icon('user-group')->collapsable(),
            ];
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes(default: true)
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
