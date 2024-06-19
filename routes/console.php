<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('emprunts:update-late-fees', function () {
    $schedule = app(Schedule::class);
    $schedule->command('emprunts:update-late-fees')->daily();
})->purpose('Update the late fees for overdue emprunts');