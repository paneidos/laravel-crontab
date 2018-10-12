<?php

namespace Paneidos\LaravelCrontab\Tests;

use Illuminate\Console\Application;
use Illuminate\Console\Scheduling\EventMutex;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Console\Scheduling\SchedulingMutex;
use Illuminate\Container\Container;
use Paneidos\LaravelCrontab\ScheduleConverter;
use PHPUnit\Framework\TestCase;

class ScheduleTest extends TestCase
{
    public function setUp()
    {
        $container = Container::getInstance();
        $container->bind(EventMutex::class, DummyEventMutex::class);
        $container->bind(SchedulingMutex::class, DummySchedulingMutex::class);
    }

    public function testScheduleConverter()
    {
        $schedule = new Schedule();
        $schedule->command('test')->daily();

        $converter = new ScheduleConverter($schedule);
        $lines = $converter->getCrontabLines();
        $this->assertCount(1, $lines);
        $php = Application::phpBinary();
        $this->assertEquals([
            "0 0 * * * {$php} artisan test > '/dev/null' 2>&1"
        ], $lines);
    }
}
