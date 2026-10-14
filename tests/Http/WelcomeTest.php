<?php

declare(strict_types=1);

it('renders the welcome page inside the app layout', function (): void {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('<title>Welcome - '.config()->string('app.name').'</title>', escape: false);
});
