<?php

namespace App\Contracts\Excel;

use Illuminate\Support\Collection;

interface ExcelMapDataServiceInterface
{
    public function mapData(array $rows, int $rowNumber, &$processedIds): array;
}