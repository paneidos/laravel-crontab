<?php

namespace Paneidos\LaravelCrontab;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;

class CrontabCommand extends Command
{
    protected $name = 'schedule:crontab';
    protected $schedule;

    public function __construct(Schedule $schedule)
    {
        parent::__construct();
        $this->schedule = $schedule;
    }

    public function handle()
    {
        $converter = new ScheduleConverter($this->schedule);
        $lines = $converter->getCrontabLines();
        foreach ($lines as $line) {
            $this->info($line);
        }
    }
}
