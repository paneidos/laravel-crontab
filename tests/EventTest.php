<?php

namespace Paneidos\LaravelCrontab\Tests;

use Illuminate\Console\Scheduling\CallbackEvent;
use Illuminate\Console\Scheduling\Event;
use Paneidos\LaravelCrontab\EventConverter;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    public function testCannotConvertCallbackEvent()
    {
        // Maybe we can in newer versions of Laravel
        $event = new CallbackEvent(new DummyEventMutex(), function () {
        });
        $eventConverter = new EventConverter($event);
        $this->assertFalse($eventConverter->isConvertable());
    }
}
