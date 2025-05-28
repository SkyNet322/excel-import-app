<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rows;
use Carbon\Carbon;

class RowController extends Controller
{
    public function index()
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

        return response()->json($result);
    }
}