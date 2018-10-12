# Laravel Crontab

Generate a crontab from your Laravel schedule.

## Why would I need this?

Laravel's scheduler works by adding a cronjob which runs every minute.
Cron daemons can do their work way more efficiently if you let them schedule the jobs.
This package adds a command (`schedule:crontab`) to generate a crontab based on the schedule you defined.

# Compatibility

Currently works with Laravel 5.6 and 5.7, as well as Laravel Zero 5.6 and 5.7. 

# Development

```
# Install dependencies
composer install
# Run tests
composer test
# Run tests & report coverage
composer test -- --coverage-test
```

# Contributing

Send a pull request, ensure you've got full test coverage.

# Planned features

* Support for `withoutOverlapping()`
* Support for `runsInMaintenanceMode()`

# License

Laravel Crontab is licensed under the MIT License.
