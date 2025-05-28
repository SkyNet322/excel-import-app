<?php

namespace App\Contracts;

interface RowRepositoryInterface
{
   public function get(): array;
}