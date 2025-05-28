<?php

namespace App\Imports;

use App\Contracts\Excel\ExcelMapDataServiceInterface;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;

class RawImport implements ToArray, WithStartRow, WithEvents
{
    protected $headersValid = false;

    protected $excelDataValid;

    protected $mapData;

    public function __construct(ExcelMapDataServiceInterface $excelMapDataServiceInterface)
    {
        $this->mapData = $excelMapDataServiceInterface;
        $this->excelDataValid = [];
    }

    public function startRow(): int
    {
        return 2;
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $sheet = $event->sheet;
                $headers = $sheet->rangeToArray('A1:C1')[0];

                if (
                    isset($headers[0], $headers[1], $headers[2]) &&
                    strtolower(trim($headers[0])) === 'id' &&
                    strtolower(trim($headers[1])) === 'name' &&
                    strtolower(trim($headers[2])) === 'date'
                ) {
                    $this->headersValid = true;
                } else {
                    throw new \Exception('Некорректные заголовки файла. Ожидались: id, name, date.');
                }
            },
        ];
    }

    public function array(array $rows)
    {
        $rowNumber = 2;
        $processedIds = [];
        if (!$this->headersValid) {
            throw new \Exception('Заголовки файла не прошли проверку.');
        }

        Redis::set("test", 0);
        try {
            $this->excelDataValid = $this->mapData->mapData($rows, $rowNumber, $processedIds);
        } catch (\Exception $e) {
            dd($this->excelDataValid);
            Redis::set("test", $this->excelDataValid['row_number']);
            throw new \Exception('Ошибка записи файла.');
        }
        Redis::set("test", $this->excelDataValid['row_number']);
    }

    public function getResults(): array {
        return $this->excelDataValid;
    }
}
