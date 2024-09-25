<?php

namespace App\Jobs\ImportProcessor;

use App\Models\Doctor;
use Laravel\Nova\Nova;
use App\Models\Patient;
use Illuminate\Support\Facades\Log;
use App\Exceptions\SaveRecordException;
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
        $doctor = Doctor::where(
            'name',
            trim($row['doctor_name']),
        )->firstOrFail();

        $patient = Patient::firstOrNew([
            'name' => trim($row['name']),
            'doctor_id' => $doctor->id,
        ]);

        $patient->sex = trim($row['sex']);
        $patient->address = trim($row['address']);
        $patient->contact_no = trim($row['contact_no']);

        throw_if(
            $patient->save() === false,
            new SaveRecordException($patient)
        );
    }
}
