<?php

namespace App\Contracts\Excel;

use Illuminate\Support\Collection;

interface ExcelSaveDataServiceInterface
{
   public function save(array $records, int $chunkSize = 10000): void;
}