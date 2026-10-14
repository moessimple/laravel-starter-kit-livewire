<?php

declare(strict_types=1);

use App\Livewire\Pages\Welcome;
use Illuminate\Support\Facades\Route;

Route::livewire('/', Welcome::class)->name('home');
