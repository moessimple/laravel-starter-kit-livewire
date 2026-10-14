<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Livewire overrides
|--------------------------------------------------------------------------
|
| Only the keys this kit changes. Livewire merges the rest from its own
| config (vendor/livewire/livewire/config/livewire.php).
|
| make:livewire creates class-based components (app/Livewire plus a view in
| resources/views/livewire) instead of single-file components, so component
| logic stays under app/ where PHPStan, Rector and the coverage gate run.
|
*/

return [

    'make_command' => [
        'type' => 'class',
        'emoji' => false,
        'with' => [
            'js' => false,
            'css' => false,
            'test' => false,
        ],
    ],

];
