<?php

namespace App\Jobs\ImportProcessor;

use Laravel\Nova\Nova;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\Log;
use App\Exceptions\SaveRecordException;
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
        $pharmacy = Pharmacy::firstOrNew([
            'name' => $row['name'],
        ]);

        $pharmacy->address = trim($row['address']);
        $pharmacy->fax = trim($row['fax']);

        throw_if(
            $pharmacy->save() === false,
            new SaveRecordException($pharmacy)
        );
    }
}
