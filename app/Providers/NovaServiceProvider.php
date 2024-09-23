<?php

namespace App\Providers;

use App\Nova\Drug;
use App\Nova\User;
use App\Nova\Doctor;
use App\Nova\Patient;
use App\Nova\Contract;
use App\Nova\Employee;
use App\Nova\Pharmacy;
use App\Nova\Schedule;
use Laravel\Nova\Nova;
use App\Nova\PharmacyDrug;
use App\Nova\Prescription;
use Illuminate\Http\Request;
use App\Nova\DrugManufacturer;
use Coreproc\NovaDataSync\Import\Nova\Import;
use Coreproc\NovaDataSync\NovaDataSync;
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
                MenuSection::dashboard(Main::class)->icon('view-grid'),

                MenuSection::make('Pharmacies Management', [
                    MenuItem::resource(Pharmacy::class),
                    MenuItem::resource(Employee::class),
                ])->icon('office-building')->collapsable(),

                MenuSection::make('Drugs Management', [
                    MenuItem::resource(DrugManufacturer::class),
                    MenuItem::resource(Drug::class),
                ])->icon('beaker')->collapsable(),

                MenuSection::make('Patients Management', [
                    MenuItem::resource(Patient::class),
                    MenuItem::resource(Doctor::class),
                ])->icon('user-group')->collapsable(),

                MenuSection::make('Support', [
                    MenuItem::resource(User::class),
                ])->icon('cog'),

                MenuSection::make('Data Sync', [
                    MenuItem::make('Imports', '/resources/imports'),
                ])->icon('cloud-download'),
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
        return [
            new NovaDataSync(),
        ];
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
