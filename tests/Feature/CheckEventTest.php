<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Events\RowCreated;
use Illuminate\Support\Facades\Broadcast;

class CheckEventTest extends TestCase
{
    public function test_event_broadcasts()
    {
        Broadcast::shouldReceive('queue')
            ->once()
            ->withArgs(function ($event) {
                if (!$event instanceof RowCreated) {
                    return false;
                }
                return strpos($event->message, 'строк записалось в бд') !== false;
            });

        event(new RowCreated('5 строк записалось в бд'));
    }
}