<?php

namespace App\Nova\Imports\DoctorImport;

use App\Models\Doctor;
use Illuminate\Support\Facades\Log;
use Coreproc\NovaDataSync\Import\Jobs\ImportProcessor;

class DoctorImportProcessor extends ImportProcessor
{
    public static function expectedHeaders(): array
    {
        return ['name', 'specialty'];
    }

    protected function rules(array $row, int $rowIndex): array
    {
        return [
            'name' => ['required', 'max:255'],
            'specialty' => ['required', 'max:255'],
        ];
    }

    protected function process(array $row, int $rowIndex): void
    {
        Log::info('processing row ' . $rowIndex);

        Doctor::firstOrCreate(
            ['name' => $row['name']],
            [
                'name' => $row['name'],
                'specialty' => $row['specialty']
            ]
        );
    }

    public static function chunkSize(): int
    {
        return 100;
    }
}
