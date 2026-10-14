<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Welcome')]
class Welcome extends Component
{
    public function render(): View
    {
        return view('livewire.pages.welcome');
    }
}
