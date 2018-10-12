<?php

namespace Paneidos\LaravelCrontab;

use Illuminate\Support\ServiceProvider;

/**
 * @codeCoverageIgnore
 */
class CrontabServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([CrontabCommand::class]);
    }

    public function boot()
    {
        //
    }
}
