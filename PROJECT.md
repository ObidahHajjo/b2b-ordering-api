# TyDelice Backend REST API

TyDelice is a Laravel backend-only REST API. The project no longer contains a React, Inertia, Vite, Tailwind, or npm frontend. Client-facing routes return JSON responses.

## Runtime And Stack

- PHP requirement: `^8.2`
- Local PHP CLI used during this cleanup: `8.5.0`
- Laravel Framework: `12.40.2`
- Laravel Fortify: `1.32.1`
- Laravel Sanctum: `4.3.2`
- Laravel Tinker: `2.10.2`
- Vinkla Hashids: `13.0.0`
- PHPUnit: `11.5.44`
- Laravel Pint: `1.26.0`
- Laravel Sail: `1.48.1`
- Faker: `1.24.1`
- Mockery: `1.6.12`
- Collision: `8.8.3`
- Pail: `1.2.4`

Frontend packages and tooling were removed: Inertia Laravel, Wayfinder, npm manifests, Vite, TypeScript, ESLint, React, Tailwind, Radix UI, generated JS resources, CSS resources, Blade app views, and `node_modules`.

## PHP Extensions

Composer platform requirements currently pass with:

- `ctype`
- `dom`
- `fileinfo`
- `filter`
- `hash`
- `iconv`
- `json`
- `libxml`
- `mbstring`
- `openssl`
- `pcre`
- `phar`
- `session`
- `tokenizer`
- `xml`
- `xmlwriter`

Useful local extensions detected on the development machine:

- Database: `PDO`, `pdo_sqlite`, `pdo_mysql`, `pdo_pgsql`, `sqlite3`, `mysqlnd`, `pgsql`
- Cache/queue: `redis`
- Files/media: `fileinfo`, `gd`, `zip`, `zlib`
- Internationalization and strings: `intl`, `mbstring`, `iconv`
- Debug/performance: `xdebug`, `Zend OPcache`
- Security/crypto: `openssl`, `sodium`

## Environment Defaults

The default `.env.example` configuration uses:

- `APP_ENV=local`
- `DB_CONNECTION=sqlite`
- `SESSION_DRIVER=database`
- `CACHE_STORE=database`
- `QUEUE_CONNECTION=database`
- `MAIL_MAILER=log`
- `FILESYSTEM_DISK=local`
- `REDIS_CLIENT=phpredis`

The API uses Sanctum personal access tokens. Authenticated clients send `Authorization: Bearer <token>`.

For shipping, the backend currently uses a weight-tier strategy configured in `config/company.php`.

## Architecture

- Routing:
  - `routes/api.php` contains REST API endpoints.
  - `routes/web.php` only returns a minimal JSON health-style root response.
  - Admin-only domain CRUD routes are grouped under `/api/admin/*`.
  - Public vitrine routes are grouped under `/api/public/*`.
  - Client commerce routes are grouped under `/api/client/*`.
- Auth:
  - `App\Http\Controllers\Auth\AuthController` handles API register, login, current user, and logout.
  - `App\Http\Controllers\Auth\PasswordController` handles authenticated password updates.
  - `App\Models\User` uses `Laravel\Sanctum\HasApiTokens`.
  - Fortify remains available for backend auth actions and rate limiting, but view rendering is disabled.
- User management:
  - `App\Http\Controllers\user\UserController` returns JSON for users, roles, and stores.
  - User IDs exposed to API clients are Hashids, not raw database IDs.
  - Admin-only operations use the `admin` middleware and `UserPolicy`.
  - Professional registration approval also validates the related store record.
- Public and client flows:
  - `App\Http\Controllers\Public\PublicController` exposes company presentation, public categories, and the contact form endpoint.
  - `App\Http\Controllers\Client\ProfessionalRegistrationController` handles professional signup with company data and KBIS upload.
  - `App\Http\Controllers\Client\CatalogController`, `CartController`, and `OrderController` cover client catalog browsing, cart management, checkout, and order history.
- Domain management:
  - `App\Http\Controllers\Admin\*Controller` provides JSON CRUD for catalog, sales, file, PAV, and relation tables.
  - These controllers stay thin and delegate CRUD work to services.
- Services/repositories:
  - Services live under `app/Services` as concrete classes (no per-service interface).
  - Repository interfaces and Eloquent implementations live under `app/Repositories`.
  - Repository interfaces are kept only for useful application boundaries: auth, users, roles, and stores.
  - Services depend on repository interfaces via constructor injection and resolve them through the container.
  - Simple business/domain tables use concrete Eloquent repositories that extend `BaseEloquentRepository`.
  - Simple business/domain services use concrete service classes that extend `BaseCrudService`.
  - This keeps the code junior-readable while still respecting SOLID and dependency injection where abstraction has value.
  - `AppServiceProvider` only keeps application-level configuration; services auto-resolve from the container.
  - Repository bindings are registered in `EloquentRepositoryProvider`.
- Middleware:
  - `approved` blocks pending users with JSON `403`.
  - `admin` blocks non-admin users with `403`.
- Audit:
  - `AuditLogService` records security/account events into `audit_logs`.

## Database Schema

Core application tables:

- `users`: authentication, profile fields, approval status, role/store foreign keys, 2FA fields.
- `roles`: role names such as `admin` and `user`.
- `stores`: store identity, legal status, SIRET, email, phone, validation date, optional address.
- `addresses`: city, street, number, postal code.
- `files`: store-owned uploaded file metadata.
- `contact_messages`: public contact form submissions.
- `carts`, `cart_items`: authenticated client shopping carts.
- `audit_logs`: category, event, level, message, context, user/subject, IP, user-agent, timestamp.
- `personal_access_tokens`: Sanctum API tokens.

PAV and catalog tables:

- `pavs`, `pavs_standard`, `pavs_custom`
- `etages`, `produits`, `categories`
- Relationship tables: `contient`, `localise`, `classifie`

Sales tables:

- `commandes`, `lignes`, `factures`, `reductions`
- Reduction subtype tables: `reductions_personnel`, `reductions_globale`
- Relationship tables: `effectue`, `inclut`, `compose`, `concerne`, `applique`

Laravel infrastructure tables:

- `password_reset_tokens`
- `sessions`
- `cache`, `cache_locks`
- `jobs`, `job_batches`, `failed_jobs`

## Setup And Maintenance Commands

```bash
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
php artisan test
composer validate
composer check-platform-reqs
php artisan route:list
```

`composer update` reported existing security advisories. Run `composer audit` to inspect and prioritize them.
