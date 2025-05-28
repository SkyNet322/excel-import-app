<?php

namespace App\Contracts\Excel;

use Illuminate\Support\Collection;

interface ExcelValidateServiceInterface
{
   public function validate(array $row, array &$processedIds): array;
}