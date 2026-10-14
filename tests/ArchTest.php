<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Baseline presets
|--------------------------------------------------------------------------
|
| php()/security() catch generic smells (debug output, eval, weak randomness).
| laravel() checks controller/request/middleware suffixes and model conventions;
| it allows __invoke-only controllers, so it fits a single-action controller style.
| Area-specific rules live in tests/Arch/*Test.php.
|
*/

arch()->preset()->php();
arch()->preset()->security();
arch()->preset()->laravel();

arch('strict types everywhere')
    ->expect('App')
    ->toUseStrictTypes();

arch('no blocking sleeps')
    ->expect(['sleep', 'usleep'])
    ->not->toBeUsed();
