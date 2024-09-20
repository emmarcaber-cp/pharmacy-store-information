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
        $doctor = Doctor::factory()->create();
        $patient = Patient::factory()->create();
        $drugManufacturer = DrugManufacturer::factory()->create();
        $employee = Employee::factory()->create();
        $pharmacy = Pharmacy::factory()->create();

        $users = [
            [
                'name' => 'Patient User',
                'email' => 'patient_user@email.com',
                'password' => bcrypt('pass123'),
                'auth_id' => $patient->id,
                'auth_type' => Patient::class,
            ],
            [
                'name' => 'Doctor User',
                'email' => 'doctor_user@email.com',
                'password' => bcrypt('pass123'),
                'auth_id' => $doctor->id,
                'auth_type' => Doctor::class,
            ],
            [
                'name' => 'Drug Manufacturer User',
                'email' => 'drug_manufacturer_user@email.com',
                'password' => bcrypt('pass123'),
                'auth_id' => $drugManufacturer->id,
                'auth_type' => DrugManufacturer::class,
            ],
            [
                'name' => 'Employee User',
                'email' => 'employee_user@email.com',
                'password' => bcrypt('pass123'),
                'auth_id' => $employee->id,
                'auth_type' => Employee::class,
            ],
            [
                'name' => 'Pharmacy User',
                'email' => 'pharmacy_user@email.com',
                'password' => bcrypt('pass123'),
                'auth_id' => $pharmacy->id,
                'auth_type' => Pharmacy::class,
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(['email' => $user['email']], $user);
        }
    }
}
