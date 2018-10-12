<?php

namespace Paneidos\LaravelCrontab\Tests;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\EventMutex;

class DummyEventMutex implements EventMutex
{
    public function create(Event $event)
    {
    }
    public function exists(Event $event)
    {
    }
    public function forget(Event $event)
    {
    }
}
