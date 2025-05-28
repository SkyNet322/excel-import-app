<?php

namespace App\Service;

use App\Contracts\Excel\ExcelValidateServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ExcelValidateService implements ExcelValidateServiceInterface
{
    protected array $errors = [];

    /**
     * Проверяет одну строку данных.
     *
     * @param array $row
     * @param array $processedIds
     * @return array
     */
    public function validate(array $row, array &$processedIds): array
    {
        $this->errors = [];

        // Пример проверки: все поля должны быть заполнены
        if (empty($row[0])) {
            $this->errors[] = 'Поле id обязательно.';
        }
        if (empty($row[1])) {
            $this->errors[] = 'Поле name обязательно.';
        }
        // Можно добавить свои проверки
        if (!is_numeric($row[0])) {
            $this->errors[] = 'Поле id должно быть числом.';
        }

        try {
            Carbon::create($row[2]);
        } catch (\Exception $e) {
            $this->errors[] = 'Неправильный формат даты';
        }

        if (isset($processedIds[$row[0]])) {
            $this->errors[] = 'Дубликат ID: ' . $row[0];
        }

        // Если всё хорошо
        return $this->errors;
    }
}