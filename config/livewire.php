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
| resources/views/livewire) instead of single- or multi-file components.
| Livewire runs those from a compiled copy in storage/framework/views, so
| line coverage never reaches their source and the 100% gate cannot cover them.
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
