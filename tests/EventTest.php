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

    public function testCannotConvertEventWithoutCommand()
    {
        $event = new Event(new DummyEventMutex(), '');
        $eventConverter = new EventConverter($event);
        $this->assertFalse($eventConverter->isConvertable());
    }

    public function testCanConvertEventWithCommand()
    {
        $event = new Event(new DummyEventMutex(), 'update:status');
        $eventConverter = new EventConverter($event);
        $this->assertTrue($eventConverter->isConvertable());
    }

    public function testSimpleCommand()
    {
        $event = new Event(new DummyEventMutex(), 'update:status');
        $eventConverter = new EventConverter($event);
        $this->assertEquals('* * * * *', $eventConverter->getExpression());
        $this->assertEquals("update:status > '/dev/null' 2>&1", $eventConverter->buildCommand());
        $this->assertEquals("* * * * * update:status > '/dev/null' 2>&1", $eventConverter->getCrontabLine());
    }
}
