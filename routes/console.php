<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use App\Support\LateFeeUpdater;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();





Artisan::command('update:latefees', function (LateFeeUpdater $lateFeeUpdater) {
    $lateFeeUpdater->update();
    $this->info('Late fees have been updated successfully.');
})->purpose('Update late fees for users');