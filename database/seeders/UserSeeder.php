<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Pharmacy;
use Illuminate\Database\Seeder;
use App\Models\DrugManufacturer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            Doctor::class => ['name' => 'Doctor User',],
            Patient::class => ['name' => 'Patient User'],
            DrugManufacturer::class => ['name' => 'Drug Manufacturer User'],
            Employee::class => ['name' => 'Employee User'],
            Pharmacy::class => ['name' => 'Pharmacy User'],
        ];

        foreach ($userTypes as $model => $userInformation) {
            $modelInstance = $model::factory()->create($userInformation);
            // $userName = $userInformation['name'];

            // User::firstOrCreate(
            //     ['email' => strtolower(str_replace(' ', '_', $userName)) . '@email.com'],
            //     [
            //         'name' => $modelInstance->name,
            //         'password' => bcrypt('pass123'),
            //         'auth_id' => $modelInstance->id,
            //         'auth_type' => $model,
            //     ]
            // );
        }
    }
}
