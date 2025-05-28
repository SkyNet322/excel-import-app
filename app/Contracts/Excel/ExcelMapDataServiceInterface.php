<?php

namespace App\Contracts\Excel;

interface ExcelMapDataServiceInterface
{
    public function mapData(array $rows, int $rowNumber, &$processedIds): array;
}