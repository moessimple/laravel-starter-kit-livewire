# Laravel Starter Kit (Livewire)

[![tests](https://github.com/moessimple/laravel-starter-kit-livewire/actions/workflows/tests.yml/badge.svg)](https://github.com/moessimple/laravel-starter-kit-livewire/actions/workflows/tests.yml)
[![lint](https://github.com/moessimple/laravel-starter-kit-livewire/actions/workflows/lint.yml/badge.svg)](https://github.com/moessimple/laravel-starter-kit-livewire/actions/workflows/lint.yml)
[![static analysis](https://github.com/moessimple/laravel-starter-kit-livewire/actions/workflows/static.yml/badge.svg)](https://github.com/moessimple/laravel-starter-kit-livewire/actions/workflows/static.yml)

A blank [Laravel](https://laravel.com) skeleton for PHP 8.5 and Laravel 13, with the
quality and development workflow decided and enforced in CI from the first commit.
Livewire 4 and Tailwind CSS 4 on the frontend. No auth, no UI kit, no example code.

The Inertia and Vue twin of this kit is
[moessimple/laravel-starter-kit-inertia-vue](https://github.com/moessimple/laravel-starter-kit-inertia-vue).

## Why This Starter Kit?

A new project is where the quality bar is cheapest to set and easiest to lose. This kit
sets it on an empty repository and enforces it in CI, so it cannot quietly decay as the
code grows.

- **PHPStan at `level: max`**: no baseline, no ignored errors. A type error fails a check
  instead of accumulating.
- **100% coverage, enforced**: the build fails below 100% line coverage (Pest), plus a 100%
  type-coverage gate.
- **Class-based Livewire components**: `make:livewire` creates a class in `app/Livewire`
  instead of a Livewire 4 single-file component. Livewire runs single- and multi-file
  components from a compiled copy, so line coverage never reaches their source and the
  100% gate could not cover them ([`config/livewire.php`](config/livewire.php)).
- **Real-browser tests**: the app runs for real in headless Chromium as part of the normal
  test run.
- **Deterministic test baseline**: every test starts from the same fixed state, so a result
  never depends on the clock, the filesystem, the network, or the machine it runs on
  ([`tests/Pest.php`](tests/Pest.php)).
- **Auto-modernization**: Rector and a hardened Pint ruleset keep PHP on current idioms and
  a consistent style; `vp fmt` / `vp lint` ([vite-plus](https://viteplus.dev)) do the same
  for the frontend. One deliberate boundary: it never makes classes
  `final`, so they stay open to extension.
- **Known vulnerable dependency updates blocked**: Composer 2.11+ blocks affected package
  versions during `require` and `update`, and npm install scripts are turned off.
- **Better Laravel defaults** via
  [Essentials](https://github.com/nunomaduro/essentials): strict models, automatic eager
  loading, immutable dates, prohibited destructive commands, forced HTTPS in production.
  Under these, a missing eager load or a mutated date fails a test instead of reaching
  production.
- **Split CI**: `lint`, `static analysis` and `tests` are separate checks, alongside
  weekly Dependabot for GitHub Actions with a 3-day cooldown on new releases.
- **AI-agent environment, wired in**: Laravel Boost's MCP server, a curated set of skills
  under [`.claude/skills/`](.claude/skills/), and project conventions in
  [`.ai/rules/`](.ai/rules/), so an agent picks up the house style on the first prompt.

Nothing above is documentation-only: it all runs on every push.

## Getting Started

> **Requires PHP 8.5+, Composer 2.11+, Node 24+, npm 11.17+, and a code coverage driver like
> [Xdebug](https://xdebug.org/docs/install).**

Use the **Use this template** button on GitHub and clone your new repository, or create
a local project with Composer:

```bash
composer create-project \
  --repository='{"type":"vcs","url":"https://github.com/moessimple/laravel-starter-kit-livewire"}' \
  --remove-vcs \
  moessimple/laravel-starter-kit-livewire example-app dev-main
```

Replace `example-app` with your project directory. `dev-main` uses the latest code on
`main`.

### Initial Setup

Navigate to your project directory and run the setup:

```bash
cd example-app
composer setup
```

`composer setup` takes a fresh checkout to a running app: dependencies, `.env` and app key,
migrations, the headless Chromium the browser tests need, and a first frontend build.

### Dev Servers

```bash
composer dev
```

Starts the Laravel server, queue worker, log viewer and Vite dev server together.

### Verify Installation

```bash
composer test
```

Runs the full gate in order: lint, type coverage, static analysis, unit tests, browser
tests. The kit ships at 100% line and type coverage. A fresh install resolves the latest
dependency releases, so a new release can occasionally fail a check.

### Repository Settings

GitHub does not copy repository settings from a template. Add a ruleset for `main` that
requires a pull request before merging and the status checks `lint`, `static`, `app` and
`browser`, so a failing check blocks the merge. Set the number of required approvals to fit
your team. Then take the steps under [Security](#security).

### Daily Workflow

Add components with `php artisan make:livewire Name` (or `Pages/Name` for a full-page
component routed via `Route::livewire()`); business logic goes in `app/Actions` (see
[`.ai/rules/`](.ai/rules/)). Every runtime line needs test coverage, or
`composer test` fails. Before committing, run `composer lint` to apply Rector, Pint and the
frontend fixers in place.

## Available Tooling

### Development

- `composer dev`: Laravel server, queue worker, log viewer and Vite, together.

### Code Quality

- `composer lint`: Rector, Pint and `vp fmt` / `vp lint`, fixing in place.
- `composer test:lint`: the same checks read-only (Rector `--dry-run`, Pint `--test`,
  frontend in check mode).
- `composer test:composer`: validates `composer.json` strictly and checks that `composer.lock`
  is up to date with it.

### Testing

- `composer test:types`: PHPStan at `level: max`.
- `composer test:type-coverage`: fails under 100% type coverage (Pest).
- `composer test:unit`: Pest under a 100% line-coverage gate.
- `composer test:browser`: the headless Chromium suite.
- `composer test`: the full gate, in order.

### Maintenance

- `composer update:dependencies`: bumps Composer and npm packages within their version
  constraints, then refreshes the Boost guidelines and skills.

## Security

Built in:

- When Composer resolves dependencies, it skips versions with a known vulnerability and
  versions flagged as malware. After `composer update` and `composer require` it lists
  advisories that affect the installed packages.
- npm runs no install scripts ([`.npmrc`](.npmrc)).
- `composer test:audit` checks `composer.lock` and `package-lock.json` on demand.

For your project:

1. **Record the packages you trust.** The kit ships [Vet](https://github.com/laravel/vet),
   which shows the code an update is about to write into `vendor/`. A new project starts
   without trust entries, so Composer reports `Vet has no trust entry`. Record what
   `composer setup` installed and commit `vet.json`:

   ```bash
   ./vendor/bin/vet --init
   ```

2. **Turn on Dependabot alerts and security updates** in the repository settings. GitHub
   then checks your lockfiles against new advisories and opens a fix pull request.
3. **Optional: wait before taking new releases.** With a cooldown, Composer and npm skip
   releases younger than three days when they resolve dependencies. Add it to `config` in
   `composer.json`:

   ```json
   "policy": {
       "cooldown": {
           "period": "3 days"
       }
   }
   ```

   And add a line to `.npmrc`:

   ```ini
   min-release-age=3
   ```

   To take a security fix inside that wait, update only that package:

   ```bash
   composer update vendor/package --no-cooldown
   npm update package-name --min-release-age-exclude=package-name
   ```

## Credits

Built on Laravel's
[blank-livewire-starter-kit](https://github.com/laravel/blank-livewire-starter-kit).
Structure and tooling choices are adapted from
**[Nuno Maduro](https://github.com/nunomaduro)**'s
[laravel-starter-kit-inertia-vue](https://github.com/nunomaduro/laravel-starter-kit-inertia-vue).

## License

Released under the [MIT License](LICENSE).
