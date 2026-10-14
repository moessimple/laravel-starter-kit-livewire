<?php

declare(strict_types=1);

it('shows the getting-started call to action', function (): void {
    visit('/')
        ->assertSee("Let's get started")
        ->assertNoJavaScriptErrors()
        ->assertNoConsoleLogs();
});
