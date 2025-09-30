# Role-Based Auth & Product Management API

A Laravel 11 RESTful API for user authentication, role-based access control, and product management using Sanctum and Spatie Permission.

---

## Features

- **User Authentication** (login/logout) via Laravel Sanctum
- **Role-Based Access Control** (Admin, Manager, User) via Spatie Permission
- **Product CRUD** with permission checks
- **Consistent JSON responses**
- **Comprehensive API documentation** (`API_DOCUMENTATION.md`)

---

## Quick Start

### 1. Clone & Install

```bash
git clone https://github.com/Shovickbarua/role-based.git
cd role-based
composer install
```

### 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```
Edit `.env` and set your database credentials.

### 3. Migrate & Seed

```bash
php artisan migrate
php artisan db:seed
```

### 4. Serve

```bash
php artisan serve
```
API will be available at:  
`http://localhost:8000/api`

---

## Default Users

| Email               | Password | Role   |
|---------------------|----------|--------|
| admin@example.com   | password | Admin  |
| manager@example.com | password | Manager|
| user@example.com    | password | User   |

---

## API Usage

### Authentication

- **Login:** `POST /api/login`
- **Logout:** `POST /api/logout`

### Products

- **List:** `GET /api/products`
- **Create:** `POST /api/products`
- **Show:** `GET /api/products/{id}`
- **Update:** `PUT/PATCH /api/products/{id}`
- **Delete:** `DELETE /api/products/{id}`

All protected endpoints require:

- `Authorization: Bearer {token}`

---

## Permissions & Roles

- **Admin:** Full access
- **Manager:** Manage products
- **User:** View products

Permissions:
- `view products`
- `create products`
- `edit products`
- `delete products`

---

## Error Handling

- `401 Unauthorized`: Invalid/missing token
- `403 Forbidden`: Insufficient permissions
- `422 Validation Error`: Invalid input
- `404 Not Found`: Resource missing

---

## Documentation

See [`API_DOCUMENTATION.md`](./API_DOCUMENTATION.md) for:
- Full endpoint details
- Request/response examples
- Setup instructions
- Usage scenarios
- Troubleshooting

---

## Testing

Use Postman, Insomnia, or cURL for API testing.  
Example login request:

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "admin@example.com", "password": "password"}'
```

---

## License

MIT

---

*For questions or support, open an issue or contact the maintainer.*
