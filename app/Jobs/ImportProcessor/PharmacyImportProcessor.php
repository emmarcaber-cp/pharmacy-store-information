<?php

namespace App\Jobs\ImportProcessor;

use App\Models\Pharmacy;
use Illuminate\Support\Facades\Log;
use Coreproc\NovaDataSync\Import\Jobs\ImportProcessor;

class PharmacyImportProcessor extends ImportProcessor
{
    public static function expectedHeaders(): array
    {
        return ['name', 'address', 'fax'];
    }

    protected function rules(array $row, int $rowIndex): array
    {
        return [
            'name' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'fax' => ['required', 'max:255'],
        ];
    }

    protected function process(array $row, int $rowIndex): void
    {
        Pharmacy::firstOrCreate(
            [
                'name' => $row['name'],
            ],
            [
                'address' => $row['address'],
                'fax' => $row['fax'],
            ]
        );
    }
}
