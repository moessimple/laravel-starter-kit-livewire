<?php

declare(strict_types=1);

arch('request state stays in the http layer')
    ->expect(['request', 'session', 'auth', 'cookie'])
    ->toOnlyBeUsedIn(['App\Http', 'App\Livewire']);
