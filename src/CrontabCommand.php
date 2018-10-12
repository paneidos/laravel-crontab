<?php

namespace Paneidos\LaravelCrontab;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Symfony\Component\Console\Input\InputOption;

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
        $defaultPath = $this->laravel->bound('path.base') ? $this->laravel->make('path.base') : null;
        $path = $this->option('working-directory') ?: $defaultPath;
        $lines = $converter->getCrontabLines($path);
        foreach ($lines as $line) {
            $this->info($line);
        }
    }

    protected function getOptions()
    {
        return [
            ['working-directory', 'd', InputOption::VALUE_REQUIRED, 'The working directory for the cron jobs.'],
        ];
    }
}
