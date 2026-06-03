# TyDelice Project Rules

These rules apply to every future change in this repository.

## Project Scope

- This project is a backend-only Laravel REST API.
- Do not add frontend frameworks, frontend build tools, Blade app pages, Inertia, React, Vite, Tailwind, npm scripts, or `node_modules`.
- Client-facing behavior must return JSON.
- Public API routes belong in `routes/api.php`.
- `routes/web.php` should stay minimal and must not grow into a rendered web application.
- Authentication is token-based with Laravel Sanctum personal access tokens.
- Authenticated clients use `Authorization: Bearer <token>`.

## Change Rules

- Every behavior change must include matching tests.
- Every class change must be reviewed for affected tests; update or add tests in the same change.
- Every controller change must include Feature/API tests for success, validation failure, auth failure, and authorization failure when relevant.
- Every FormRequest change must include validation tests.
- Every middleware or policy change must include authorization/access tests.
- Every model relationship, cast, fillable field, or database-related change must include tests that prove the new behavior works.
- Every migration that changes schema must be reflected in documentation when it affects the project data model.
- Every public API contract change must update `API.md`.
- Every stack, dependency, extension, or setup change must update `PROJECT.md`.
- Every project rule or workflow change must update this file.

## API Rules

- Use JSON responses only for client-facing endpoints.
- Use clear HTTP status codes:
  - `200` for successful read/update/delete/logout.
  - `201` for successful creation.
  - `401` for missing or invalid authentication.
  - `403` for forbidden access or pending approval.
  - `404` for missing resources.
  - `422` for validation errors.
- Do not expose raw user database IDs in API responses; use Hashids where already established.
- Keep response shapes consistent with `API.md`.
- Do not add browser-session redirects to API endpoints.
- Do not return Blade, Inertia, or HTML views from API controllers.

## Auth And Authorization Rules

- Protect private API routes with `auth:sanctum`.
- Use middleware and policies for authorization instead of inline role checks when practical.
- Admin-only endpoints must use the `admin` middleware or an explicit policy check.
- Pending users must receive JSON `403`, not redirects.
- Logout must revoke the current Sanctum token.
- Never store or return plain passwords.

## Testing Rules

- Run the full test suite before finishing a change:

```bash
php artisan test
```

- For dependency, runtime, or setup changes, also run:

```bash
composer validate
composer check-platform-reqs
php artisan route:list
```

- Route list should stay API-focused. No frontend page routes should reappear.
- Tests should use JSON helpers such as `getJson`, `postJson`, `patchJson`, `putJson`, and `deleteJson`.
- Prefer focused Feature tests for API behavior and Unit tests for isolated service/model logic.

## Dependency Rules

- Composer dependencies must be backend/API dependencies only.
- Do not add npm dependencies or frontend package manifests.
- If adding a dependency, document why it is needed in `PROJECT.md`.
- After Composer changes, keep `composer.json` and `composer.lock` in sync.
- If Composer reports security advisories, mention them in the work summary and do not ignore them silently.

## Documentation Rules

- Keep `PROJECT.md` as the source of truth for stack, versions, extensions, environment defaults, architecture, and database schema.
- Keep `API.md` as the source of truth for endpoints, request bodies, response shapes, auth requirements, and status codes.
- Keep documentation concise but concrete enough for another engineer or agent to continue safely.

## Code Style Rules

- Code must stay junior-friendly: simple names, simple control flow, and no clever abstractions.
- Respect SOLID principles where they help readability and maintainability.
- Use dependency injection for services, repositories, and collaborators; do not create hard-coded service instances inside business logic.
- Follow the existing Laravel service/repository structure unless there is a strong reason to change it.
- Use Laravel validation, policies, middleware, resources/serializers, and Eloquent relationships instead of ad hoc logic.
- Keep controller methods thin; move reusable business logic into services.
- Every function and method must declare an explicit return type.
- Every function and method must have a PHPDoc block with:
  - A short phrase explaining what the function does.
  - Every parameter documented with `@param`.
  - The return value documented with `@return`.
- Keep PHPDoc short and useful; do not write long explanations for obvious code.
- Avoid N+1 queries. Use eager loading with `with()`, `load()`, or query joins where appropriate.
- When adding list endpoints, check relationships used during serialization and eager-load them before mapping results.
- Use Laravel Pint for PHP formatting:

```bash
vendor/bin/pint
```

- Do not revert unrelated user work.
- Do not delete or rewrite untracked user files unless the task explicitly requires it.
