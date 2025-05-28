<?php

namespace App\Contracts\Excel;

interface ExcelSaveDataServiceInterface
{
   public function save(array $records, int $chunkSize = 10000): void;
}