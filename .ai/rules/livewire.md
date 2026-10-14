---
paths:
  - 'app/Livewire/**'
  - 'resources/views/livewire/**'
  - 'resources/views/layouts/**'
  - 'tests/Http/Livewire/**'
---

# Livewire

## Class-based components only

- Every Livewire component is class-based: a class in `app/Livewire` extending `Livewire\Component`, rendering a view in `resources/views/livewire`.
- Do not create single-file (SFC) or multi-file (MFC) components, even though they are the Livewire v4 default. Their PHP lives in `resources/views`, outside PHPStan, Rector, Pint, type coverage and the 100% line-coverage gate, which all scan `app/`.
- Create components with `php artisan make:livewire Name` (config/livewire.php makes `class` the default) and full-page components with `php artisan make:livewire Pages/Name`, routed via `Route::livewire()`.
- Full-page components render into `resources/views/layouts/app.blade.php` (`layouts::app`). Set the page title with `#[Title('...')]`.
- Components are the HTTP layer of a Livewire app: they validate and authorize, then delegate business logic to an Action (see `.ai/rules/actions.md`).

## Testing

- Every component has a test at the mirrored path under `tests/Http/Livewire/` using `Livewire::test()`.

```php
<?php

declare(strict_types=1);

use App\Livewire\Counter;
use Livewire\Livewire;

it('increments the count', function (): void {
    Livewire::test(Counter::class)
        ->call('increment')
        ->assertSet('count', 1);
});
```
