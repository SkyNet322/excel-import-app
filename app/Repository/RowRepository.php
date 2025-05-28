<?php

namespace App\Repository;

use App\Contracts\RowRepositoryInterface;
use App\Models\Rows;
use Carbon\Carbon;

class RowRepository implements RowRepositoryInterface
{
    /**
     * Получить сгруппированные данные из базы данных.
     * @return array
     */
    public function get(): array
    {
        $records = Rows::orderBy('date', 'asc')->get();

        $grouped = $records->groupBy(function ($item) {
            return Carbon::create($item->date)->toDateString();
        });

        $result = [];

        foreach ($grouped as $date => $items) {
            $result[] = [
                'date' => $date,
                'items' => $items->values()->all(),
            ];
        }

        return $result;
    }
}