<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case and deterministic state
|--------------------------------------------------------------------------
|
| Unit, Http, Console and Browser tests start from a known baseline: real random strings and
| UUIDs (undoing a fake a previous test forgot to reset), a hard failure on any unfaked
| outbound process (the twin of essentials' PreventStrayRequests), a fresh faked default
| filesystem disk, and frozen time so time-based assertions do not race the clock.
| LazilyRefreshDatabase sits on top: it migrates and opens its transaction only when a test
| actually touches the database (Action unit tests do; pure unit tests pay nothing).
|
| This covers Browser tests too: pest-plugin-browser runs the app in-process through the same
| container and database connection as the test (no artisan serve), so the transaction and the
| fakes are visible to browser-driven requests. Browser tests also join the `browser` group,
| which a bare pest or artisan test run excludes (see phpunit.xml).
|
| Arch tests are not extended here: they are static, need no TestCase, and never hit a
| connection. They still run via the Arch testsuite in phpunit.xml.
|
*/

pest()->extend(TestCase::class)
    ->use(LazilyRefreshDatabase::class)
    ->beforeEach(function (): void {
        Str::createRandomStringsNormally();
        Str::createUuidsNormally();
        Process::preventStrayProcesses();
        Storage::fake();

        $this->freezeTime();
    })
    ->in('Unit', 'Http', 'Console', 'Browser');

pest()->group('browser')->in('Browser');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
*/

expect()->extend('toBeOne', fn () => $this->toBe(1));

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
*/

function something(): void
{
    // ..
}
