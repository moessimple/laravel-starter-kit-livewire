<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Factories\Factory;

arch('factories extend the base factory and define their state')
    ->expect('Database\Factories')
    ->toExtend(Factory::class)
    ->toHaveMethod('definition');
