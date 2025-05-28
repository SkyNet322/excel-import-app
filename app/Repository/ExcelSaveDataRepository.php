<?php

namespace App\Repository;

use App\Contracts\Excel\ExcelSaveDataRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\Rows;

class ExcelSaveDataRepository implements ExcelSaveDataRepositoryInterface
{
    /**
     * Сохраняет коллекцию записей в базу данных.
     *
     * @param array $records
     * @param int $chunkSize
     * @return int
     */
    public function save(array $records, int $chunkSize = 10000): int
    {
        $chunks = array_chunk($records, $chunkSize);

        foreach ($chunks as $chunk) {
            DB::table((new Rows)->getTable())->upsert($chunk, ['id'], ['id', 'name', 'date']);
        }

        return count($records);
    }
}