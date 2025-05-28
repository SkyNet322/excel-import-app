<?php

namespace App\Service;

use App\Contracts\Excel\ExcelSaveDataServiceInterface;
use App\Contracts\Excel\ExcelSaveDataRepositoryInterface;
use App\Events\RowCreated;
use Illuminate\Support\Facades\DB;

class ExcelSaveDataService implements ExcelSaveDataServiceInterface
{
    protected $saveRepo;

    protected ExcelSaveDataRepositoryInterface $validate;

    public function __construct(ExcelSaveDataRepositoryInterface $excelSaveDataRepositoryInterface)
    {
        $this->saveRepo = $excelSaveDataRepositoryInterface;
    }

    /**
     * Сохраняет коллекцию записей в базу данных.
     *
     * @param array $records
     * @param int $chunkSize
     * @return void
     */
    public function save(array $records, int $chunkSize = 10000): void
    {
        DB::transaction(function () use ($records, $chunkSize) {
            $countRecords = $this->saveRepo->save($records, $chunkSize);
            event(new RowCreated($countRecords . " строк записалось в бд"));
        });
    }
}