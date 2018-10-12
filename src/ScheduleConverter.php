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

    public function getCrontabLines()
    {
        return array_map(function (Event $event) {
            return (new EventConverter($event))->getCrontabLine();
        }, $this->schedule->events());
    }
}
