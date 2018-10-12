<?php

namespace Paneidos\LaravelCrontab\Tests;

use Illuminate\Console\Application;
use Illuminate\Console\Scheduling\EventMutex;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Console\Scheduling\SchedulingMutex;
use Illuminate\Container\Container;
use Paneidos\LaravelCrontab\CrontabCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class CrontabCommandTest extends TestCase
{
    public function setUp()
    {
        $container = Container::getInstance();
        $container->bind(EventMutex::class, DummyEventMutex::class);
        $container->bind(SchedulingMutex::class, DummySchedulingMutex::class);
    }

    public function testOutput()
    {
        $schedule = new Schedule();
        $schedule->command('test')->daily();

        $container = Container::getInstance();
        $command = new CrontabCommand($schedule);
        $command->setLaravel($container);

        $input = new ArrayInput([]);
        $output = new BufferedOutput();
        $command->run($input, $output);

        $contents = $output->fetch();
        $php = Application::phpBinary();
        $this->assertContains("0 0 * * * {$php} artisan test > '/dev/null' 2>&1", $contents);
    }

    public function testWorkingDirectoryOutput()
    {
        $schedule = new Schedule();
        $schedule->command('test')->daily();

        $container = Container::getInstance();
        $container->instance('path.base', '/home/app');
        $command = new CrontabCommand($schedule);
        $command->setLaravel($container);

        $input = new ArrayInput([
            '--working-directory' => '/home/app',
        ]);
        $output = new BufferedOutput();
        $command->run($input, $output);

        $contents = $output->fetch();
        $php = Application::phpBinary();
        $this->assertContains("0 0 * * * cd '/home/app' && {$php} artisan test > '/dev/null' 2>&1", $contents);
    }

    public function testCustomWorkingDirectoryOutput()
    {
        $schedule = new Schedule();
        $schedule->command('test')->daily();

        $container = Container::getInstance();
        $command = new CrontabCommand($schedule);
        $command->setLaravel($container);

        $input = new ArrayInput([
            '--working-directory' => '/home/other-app',
        ]);
        $output = new BufferedOutput();
        $command->run($input, $output);

        $contents = $output->fetch();
        $php = Application::phpBinary();
        $this->assertContains("0 0 * * * cd '/home/other-app' && {$php} artisan test > '/dev/null' 2>&1", $contents);
    }
}
