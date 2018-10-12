<?php

namespace Paneidos\LaravelCrontab;

use Illuminate\Console\Scheduling\CallbackEvent;
use Illuminate\Console\Scheduling\Event;

class EventConverter
{
    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function isConvertable(): bool
    {
        return !($this->event instanceof CallbackEvent) && !empty($this->event->command);
    }

    public function getCrontabLine()
    {
        $expression = $this->getExpression();

        $command = $this->buildCommand();

        return "{$expression} {$command}";
    }

    public function getExpression()
    {
        return $this->event->expression;
    }

    public function buildCommand()
    {
        return $this->event->buildCommand();
    }
}
