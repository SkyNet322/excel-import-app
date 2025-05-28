<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Rows;
use Carbon\Carbon;

class RowControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_index_returns_grouped_rows()
    {
        $this->artisan('migrate', ['--database' => 'sqlite']);

        // Создаем несколько записей с разными датами
        Rows::factory()->createMany([
            ['name' => 'Annmarie Galbraith', 'date' => '2023-10-01'],
            ['name' => 'Joseph Hoppe', 'date' => '2023-10-01'],
            ['name' => 'Juliana Schulze', 'date' => '2023-10-02'],
        ]);

        $response = $this->get('/api/rows');

        $response->assertStatus(200);

        $json = $response->json();

        $this->assertIsArray($json);

        $this->assertCount(2, $json);

        $firstGroup = $json[0];
        $this->assertEquals('2023-10-01', $firstGroup['date']);
        $this->assertIsArray($firstGroup['items']);
        $this->assertCount(2, $firstGroup['items']);

        $secondGroup = $json[1];
        $this->assertEquals('2023-10-02', $secondGroup['date']);
        $this->assertIsArray($secondGroup['items']);
        $this->assertCount(1, $secondGroup['items']);

        foreach ($firstGroup['items'] as $item) {
            $this->assertEquals('2023-10-01', Carbon::create($item['date'])->toDateString());
        }
    }
}