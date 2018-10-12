<?php

namespace Paneidos\LaravelCrontab;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleConverter
{
    protected $schedule;

    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    public function getCrontabLines($workingDirectory = null)
    {
        return array_map(function (Event $event) use ($workingDirectory) {
            return (new EventConverter($event))->getCrontabLine($workingDirectory);
        }, $this->schedule->events());
    }
}
