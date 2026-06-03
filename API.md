# TyDelice REST API

Base URL in local development: `http://localhost/api`

All request and response bodies are JSON. Authenticated endpoints require:

```http
Authorization: Bearer <token>
```

## Response Conventions

- `200 OK`: successful read/update/delete/logout.
- `201 Created`: successful creation.
- `401 Unauthorized`: missing token or invalid credentials.
- `403 Forbidden`: authenticated but not allowed, or pending account blocked.
- `404 Not Found`: hash id or route not found.
- `422 Unprocessable Entity`: validation failed.

Validation errors use Laravel's default JSON validation format.

## Public Vitrine

### Company Information

`GET /api/public/company`

Returns the company presentation data used by the public vitrine:

- company name
- location
- activity
- contact details
- suppliers

### Public Categories

`GET /api/public/categories`

Returns the product categories shown on the public site.

### Contact Form

`POST /api/public/contact`

Body:

```json
{
  "name": "Jean Client",
  "email": "jean@example.com",
  "phone": "0102030405",
  "company": "Magasin Test",
  "message": "Bonjour Ty Delice"
}
```

Response `201`:

```json
{
  "message": "Contact message sent."
}
```

## Professional Registration

### Register A Professional Client

`POST /api/client/register-request`

This endpoint is public and accepts a professional registration request with company information and a KBIS file upload.

Required fields:

- `first_name`
- `last_name`
- `email`
- `password`
- `password_confirmation`
- `phone`
- `company_name`
- `legal_status`
- `siret`
- `company_email`
- `company_phone`
- `kbis_file`

Response `201`:

```json
{
  "message": "Registration request submitted and awaiting approval.",
  "user": {
    "id": "hashid",
    "email": "alice@example.com",
    "store_id": 1,
    "is_active": null
  }
}
```

## Authentication

### Register

`POST /api/auth/register`

Body:

```json
{
  "first_name": "Ada",
  "last_name": "Lovelace",
  "email": "ada@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

Response `201`:

```json
{
  "token": "plain-text-token",
  "token_type": "Bearer",
  "user": {
    "id": "hashid",
    "first_name": "Ada",
    "last_name": "Lovelace",
    "name": "Ada Lovelace",
    "email": "ada@example.com",
    "phone": null,
    "role_id": null,
    "store_id": null,
    "is_active": null
  }
}
```

### Login

`POST /api/auth/login`

Body:

```json
{
  "email": "ada@example.com",
  "password": "password"
}
```

Response `200`:

```json
{
  "token": "plain-text-token",
  "token_type": "Bearer",
  "user": {}
}
```

Pending users receive `403`.

### Current User

`GET /api/auth/me`

Requires Bearer token. Returns the current serialized user.

### Logout

`POST /api/auth/logout`

Requires Bearer token. Revokes only the current access token.

### Update Password

`PUT /api/auth/password`

Requires Bearer token.

Body:

```json
{
  "current_password": "old-password",
  "password": "new-password",
  "password_confirmation": "new-password"
}
```

## Support Data

### Roles

`GET /api/roles`

Requires an approved authenticated user.

Response:

```json
{
  "roles": [
    {
      "id": 1,
      "name": "admin"
    }
  ]
}
```

### Stores

`GET /api/stores`

Requires an approved authenticated user.

Response:

```json
{
  "stores": [
    {
      "id": 1,
      "name": "TyDelice Paris"
    }
  ]
}
```

## Users

All user endpoints require `auth:sanctum` and approved account status. Mutating user-management endpoints require admin role.

### List Users

`GET /api/users`

Response:

```json
{
  "users": [
    {
      "id": "hashid",
      "name": "Ada Lovelace",
      "email": "ada@example.com",
      "role_id": 1,
      "store_id": 1,
      "is_active": "2026-06-02T10:00:00.000000Z"
    }
  ]
}
```

### Show User

`GET /api/users/{hashId}`

Returns a full serialized user.

### Create User

`POST /api/users`

Admin only.

Body:

```json
{
  "first_name": "Grace",
  "last_name": "Hopper",
  "email": "grace@example.com",
  "password": "password",
  "password_confirmation": "password",
  "phone": "0102030405",
  "role_id": 2,
  "store_id": 1
}
```

Response `201` includes `message` and `user`.

### Update User

`PATCH /api/users/{hashId}`

Admin only. Accepts any valid subset from `UpdateUserRequest`, including `first_name`, `last_name`, `email`, `password`, `password_confirmation`, and `phone`.

### Approve User

`POST /api/users/{hashId}/approve`

Admin only. Sets `is_active` to the current timestamp and also marks the related store `validation_date`.

## Client Commerce

All endpoints in this section require `auth:sanctum` and an approved account.

### Product Catalog

`GET /api/client/catalog/products`

Returns available products with their categories.

### Cart

`GET /api/client/cart`

Returns:

- `items`
- `subtotal`
- `shipping_total`
- `grand_total`
- `total_weight`

Shipping currently uses weight-based tiers defined by the backend configuration.

`POST /api/client/cart/items`

Body:

```json
{
  "produit_ref": "P10002",
  "quantity": 3
}
```

`PATCH /api/client/cart/items/{itemId}`

Body:

```json
{
  "quantity": 2
}
```

`DELETE /api/client/cart/items/{itemId}`

Removes one cart item.

### Orders And Order Slips

`GET /api/client/orders`

Returns the authenticated client order history.

`GET /api/client/orders/{numero}`

Returns one order with its ordered products, totals, and shipping amount.

`POST /api/client/orders`

Creates an order from the current cart and clears the cart.

### Delete User

`DELETE /api/users/{hashId}`

Admin only. Deletes the user and returns:

```json
{
  "message": "User deleted."
}
```

## Admin Domain Resources

All endpoints in this section require `auth:sanctum`, an approved account, and the admin role.

Each resource follows the same JSON CRUD pattern:

- `GET /api/admin/{resource}`
- `POST /api/admin/{resource}`
- `GET /api/admin/{resource}/{id}`
- `PATCH /api/admin/{resource}/{id}`
- `DELETE /api/admin/{resource}/{id}`

Available admin resources:

- `addresses`
- `applications`
- `categories`
- `classifications`
- `compositions`
- `concerns`
- `contents`
- `executions`
- `factures`
- `files`
- `floors`
- `inclusions`
- `lines`
- `locations`
- `orders`
- `pavs`
- `pav-customs`
- `pav-standards`
- `products`
- `reductions`
- `reductions-globales`
- `reductions-personnelles`

### Pending Registrations

`GET /api/admin/registrations/pending`

Returns pending professional registrations with:

- user identity
- company/store information
- uploaded KBIS file metadata

Successful list responses return a plural collection key such as `categories` or `products`.

Successful show, create, and update responses return a singular resource key such as `category` or `product`.
