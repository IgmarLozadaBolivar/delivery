<?php

namespace App\Services;

use Spatie\SimpleExcel\SimpleExcelReader;

class TruckImportService
{
    protected string $filename;
    public function __construct()
    {
        $this->filename = database_path('csv/camiones.csv');
    }

    public function import(): array
    {
        return SimpleExcelReader::create($this->filename)
            ->getRows()
            ->toArray();
    }
}
