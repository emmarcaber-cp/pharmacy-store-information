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
        $users = [
            [
                // Patient User
                'name' => 'Patient User',
                'email' => 'patient_user@email.com',
                'password' => bcrypt('pass123'),
                'auth_id' => Patient::factory()->create()->id,
                'auth_type' => Patient::class,
            ],
            [
                // Doctor User
                'name' => 'Doctor User',
                'email' => 'doctor_user@email.com',
                'password' => bcrypt('pass123'),
                'auth_id' => Doctor::factory()->create()->id,
                'auth_type' => Doctor::class,
            ],
            [
                // Drug Manufacturer User
                'name' => 'Drug Manufacturer User',
                'email' => 'drug_manufacturer_user@email.com',
                'password' => bcrypt('pass123'),
                'auth_id' => DrugManufacturer::factory()->create()->id,
                'auth_type' => DrugManufacturer::class,
            ],
            [
                // Employee User
                'name' => 'Employee User',
                'email' => 'employee_user@email.com',
                'password' => bcrypt('pass123'),
                'auth_id' => Employee::factory()->create()->id,
                'auth_type' => Employee::class,
            ],
            [
                // Pharmacy User
                'name' => 'Pharmacy User',
                'email' => 'pharmacy_user@email.com',
                'password' => bcrypt('pass123'),
                'auth_id' => Pharmacy::factory()->create()->id,
                'auth_type' => Pharmacy::class,
            ]
        ];

        foreach ($users as $user) {
            User::firstOrCreate($user);
        }
    }
}
