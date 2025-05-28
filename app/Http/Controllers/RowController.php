<?php

namespace App\Http\Controllers;

use App\Contracts\RowServiceInterface;
use App\Http\Controllers\Controller;

class RowController extends Controller
{
    protected $rowService;

    public function __construct(RowServiceInterface $rowServiceInterface)
    {
        $this->rowService = $rowServiceInterface;
    }

    public function index()
    {
        $result = $this->rowService->get();

        return response()->json($result);
    }
}