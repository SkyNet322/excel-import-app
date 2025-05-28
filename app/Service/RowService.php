<?php

namespace App\Service;

use App\Contracts\RowRepositoryInterface;
use App\Contracts\RowServiceInterface;

class RowService implements RowServiceInterface
{

    protected $rowRepository;

    public function __construct(RowRepositoryInterface $rowRepositoryInterface) {
        $this->rowRepository = $rowRepositoryInterface;
    }

    public function get(): array
    {
        return $this->rowRepository->get();
    }
}