<?php

namespace App\Jobs\ExportProcessor;

use App\Models\Doctor;
use Illuminate\Contracts\Database\Query\Builder;

class DoctorExportProcessor extends BaseExportProcessor
{
    public function query(): Builder
    {
        $query = Doctor::query();

        if (isset($this->filters['specialty'])) {
            return $query->where('specialty', $this->filters['specialty']);
        }

        return $query;
    }
}
