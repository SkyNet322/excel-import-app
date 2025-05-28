<?php

namespace App\Contracts\Excel;

interface ExcelValidateServiceInterface
{
   public function validate(array $row, array &$processedIds): array;
}