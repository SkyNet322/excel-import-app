<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use Illuminate\Http\UploadedFile;
use App\Service\ExcelSaveDataService;

class ExcelImportTest extends TestCase
{
    /** @test */
    public function test_upload_excel_file()
    {

        $this->artisan('migrate', ['--database' => 'sqlite']);

       // Создаем мок сервиса
        $mockSaveData = Mockery::mock(ExcelSaveDataService::class);
        $mockSaveData->shouldReceive('save')->once();

        // Внедряем мок в контейнер Laravel
        $this->app->instance(ExcelSaveDataService::class, $mockSaveData);

        // Создаем тестовый файл (можно использовать fake файл)
        $filePath = public_path('excel_for_test.xlsx');

        // Выполняем POST-запрос на ваш маршрут
        $response = $this->postJson('/api/upload-excel', [
            'file' => new UploadedFile($filePath, 'excel_for_test.xlsx', null, null, true),
        ]);

        // Проверяем статус ответа
        $response->assertStatus(200);
    }
}