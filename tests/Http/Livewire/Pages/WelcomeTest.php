<?php

declare(strict_types=1);

use App\Livewire\Pages\Welcome;
use Livewire\Livewire;

it('shows the getting-started links', function (): void {
    Livewire::test(Welcome::class)
        ->assertOk()
        ->assertSee(['Documentation', 'Laracasts']);
});
