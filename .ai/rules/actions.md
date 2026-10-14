---
paths:
  - 'app/Actions/**'
---

# Actions

## Action classes for business logic

- This application uses the Action pattern and prefers for much logic to live in reusable and composable Action classes.
- Actions live in `app/Actions`, they are named based on what they do, with an `Action` suffix.
- Actions will be called from many different places: jobs, commands, HTTP requests, API requests, MCP requests, and more.
- Create dedicated Action classes for business logic with a single `handle()` method.
- Inject dependencies via constructor using private promoted properties.
- Wrap complex operations in `DB::transaction()` within actions when multiple models are involved.
- Some actions won't require dependencies via `__construct` and they can use just the `handle()` method.
- Every new or changed action must be covered by a test. Prefer an isolated unit test at the mirrored path under `tests/Unit/Actions/`; a feature test that drives the action counts toward the 100% line-coverage gate too.

```php
<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;

class CreateFavoriteAction
{
    public function __construct(private FavoriteService $favorites)
    {
        //
    }

    public function handle(User $user, string $favorite): bool
    {
        return $this->favorites->add($user, $favorite);
    }
}
```
