<?php

namespace App\Service;

use App\Contracts\Excel\ExcelMapDataServiceInterface;
use App\Contracts\Excel\ExcelValidateServiceInterface;
use Carbon\Carbon;

class ExcelMapDataService implements ExcelMapDataServiceInterface
{
    protected $validator;

    public function __construct(ExcelValidateServiceInterface $excelValidateServiceInterface)
    {
        $this->validator = $excelValidateServiceInterface;
    }

    /**
     * Маппинг и валидация данных из эксель.
     *
     * @param array $rows
     * @param int $rowNumber
     * @param int $processedIds
     * @return array
     */
    public function mapData(array $rows, int $rowNumber, &$processedIds): array
    {
        $result = [];
        foreach ($rows as $row) {
            $currentId = $row[0];
            $validationResult = $this->validator->validate($row, $processedIds);

            if (empty($validationResult)) {
                $result['valid'][] = [
                    'id' => $currentId,
                    'name' => $row[1],
                    'date' => Carbon::create($row[2]),
                ];
                $processedIds[$currentId] = true;
            } else {
                $result['invalid'][] = [
                    'number_row_error' => $rowNumber,
                    'errors' => $validationResult,
                ];
            }
            $result['row_number'][] = $rowNumber++;
        }

        return $result;
    }
}