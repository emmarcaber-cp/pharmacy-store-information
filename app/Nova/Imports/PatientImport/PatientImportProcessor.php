<?php

namespace App\Nova\Imports\PatientImport;

use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Log;
use Coreproc\NovaDataSync\Import\Jobs\ImportProcessor;

class PatientImportProcessor extends ImportProcessor
{
    public static function expectedHeaders(): array
    {
        return ['name', 'doctor_name', 'sex', 'address', 'contact_no'];
    }

    protected function rules(array $row, int $rowIndex): array
    {
        return [
            'name' => ['required', 'max:255'],
            'doctor_name' => ['required', 'max:255', 'exists:doctors,name'],
            'sex' => ['required', 'in:male,female'],
            'address' => ['required', 'max:255'],
            'contact_no' => ['required', 'max:255'],
        ];
    }

    protected function process(array $row, int $rowIndex): void
    {
        Log::info('processing row ' . $rowIndex);

        $doctor = Doctor::where('name', $row['doctor_name'])->first();

        Patient::firstOrCreate(
            [
                'doctor_id' => $doctor->id,
                'name' => $row['name'],
            ],
            [
                'sex' => $row['sex'],
                'address' => $row['address'],
                'contact_no' => $row['contact_no'],
            ]
        );
    }

    public static function chunkSize(): int
    {
        return 100;
    }
}
