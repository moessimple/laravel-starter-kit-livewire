<?php

declare(strict_types=1);

use App\Models\User;

it('casts the user timestamps and password', function (): void {
    expect((new User)->getCasts())->toMatchArray([
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ]);
});
