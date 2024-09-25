<?php

namespace App\Jobs\ImportProcessor;

use App\Models\Drug;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Support\Facades\Log;
use Coreproc\NovaDataSync\Import\Jobs\ImportProcessor;

class PrescriptionImportProcessor extends ImportProcessor
{
    public static function expectedHeaders(): array
    {
        return ['doctor_name', 'patient_name', 'drug_trade_name', 'quantity', 'prescribed_at'];
    }

    protected function rules(array $row, int $rowIndex): array
    {
        return [
            'doctor_name' => ['required', 'max:255', 'exists:doctors,name'],
            'patient_name' => ['required', 'max:255', 'exists:patients,name'],
            'drug_trade_name' => ['required', 'max:255', 'exists:drugs,trade_name'],
            'quantity' => ['required', 'numeric'],
            'prescribed_at' => ['required', 'date_format:Y-m-d H:i:s'],
        ];
    }

    protected function process(array $row, int $rowIndex): void
    {
        $doctor = Doctor::where('name', $row['doctor_name'])->first();
        $patient = Patient::where('name', $row['patient_name'])->first();
        $drug = Drug::where('trade_name', $row['drug_trade_name'])->first();

        Prescription::firstOrCreate([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'drug_id' => $drug->id,
            'quantity' => $row['quantity'],
            'prescribed_at' => $row['prescribed_at'],
        ], [
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'drug_id' => $drug->id,
            'quantity' => $row['quantity'],
            'prescribed_at' => $row['prescribed_at'],
        ]);
    }
}
