<?php

namespace App\Contracts\Excel;

interface ExcelSaveDataRepositoryInterface
{
   public function save(array $records, int $chunkSize = 10000): int;
}