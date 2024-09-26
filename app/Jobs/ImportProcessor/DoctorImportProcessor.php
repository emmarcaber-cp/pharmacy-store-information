<?php

namespace App\Jobs\ImportProcessor;

use App\Models\Doctor;
use Laravel\Nova\Nova;
use Laravel\Nova\Actions\ActionEvent;
use App\Exceptions\SaveRecordException;
use Coreproc\NovaDataSync\Import\Jobs\ImportProcessor;

class DoctorImportProcessor extends ImportProcessor
{
    public static function expectedHeaders(): array
    {
        return [
            'name',
            'specialty'
        ];
    }

    protected function rules(array $row, int $rowIndex): array
    {
        return [
            'name' => [
                'required',
                'max:255'
            ],
            'specialty' => [
                'required',
                'max:255'
            ],
        ];
    }

    protected function process(array $row, int $rowIndex): void
    {
        $doctor = Doctor::firstOrNew([
            'name' => $row['name'],
        ]);

        $doctor->specialty = trim($row['specialty']);

        throw_if(
            $doctor->save() === false,
            new SaveRecordException($doctor)
        );
    }
}
