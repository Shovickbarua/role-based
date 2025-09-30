# Role-Based Auth & Product Management API

A Laravel 12 RESTful API for user authentication, role-based access control, and product management using Sanctum and Spatie Permission.

---

## Features

- **User Authentication** (login/logout) via Laravel Sanctum
- **Role-Based Access Control** (Admin, Manager, User) via Spatie Permission
- **Product CRUD** with permission checks
- **Consistent JSON responses**

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

## API Documentation

### Overview
This API provides role-based authentication and product management functionality using Laravel Sanctum for authentication and Spatie Laravel Permission for role-based access control.

### Base URL
```
http://localhost:8000/api
```

### Authentication
The API uses Laravel Sanctum for token-based authentication. Include the Bearer token in the Authorization header for protected routes.

```
Authorization: Bearer {your_token_here}
```

### Response Format
All API responses follow a consistent JSON format:

#### Success Response
```json
{
    "success": true,
    "data": {
        // Response data
    },
    "message": "Success message"
}
```

#### Error Response
```json
{
    "success": false,
    "message": "Error message",
    "data": {
        // Error details (optional)
    }
}
```

---

### Authentication Endpoints

#### 1. Login
Authenticate a user and receive an access token.

**Endpoint:** `POST /api/login`

**Request Body:**
```json
{
    "email": "user@example.com",
    "password": "password"
}
```

**Validation Rules:**
- `email`: required, must be a valid email format
- `password`: required

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "token": "1|abc123def456...",
        "message": "Logged In successfully"
    }
}
```

**Error Response (401):**
```json
{
    "success": false,
    "message": "Authentication Error"
}
```

**Example cURL:**
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@example.com",
    "password": "password"
  }'
```

#### 2. Logout
Revoke all user tokens and log out.

**Endpoint:** `POST /api/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "message": "Logged Out successfully"
    }
}
```

**Example cURL:**
```bash
curl -X POST http://localhost:8000/api/logout \
  -H "Authorization: Bearer 1|abc123def456..."
```

---

### Product Management Endpoints

All product endpoints require authentication and appropriate permissions.

#### 1. Get All Products
Retrieve a list of all products (requires 'view products' permission).

**Endpoint:** `GET /api/products`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "data": [
            {
                "id": 1,
                "name": "Product Name",
                "description": "Product description",
                "price": "99.99",
                "stock": 10,
                "user_id": 1,
                "status": "active",
                "created_at": "2024-01-01T00:00:00.000000Z",
                "updated_at": "2024-01-01T00:00:00.000000Z"
            }
        ],
        "message": "Products retrieved successfully"
    }
}
```

**Error Response (403):**
```json
{
    "success": false,
    "message": "Insufficient permissions"
}
```

#### 2. Create Product
Create a new product (requires 'create products' permission).

**Endpoint:** `POST /api/products`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "name": "New Product",
    "description": "Product description",
    "price": 99.99,
    "stock": 50
}
```

**Validation Rules:**
- `name`: required, string, max 255 characters
- `description`: optional, string
- `price`: required, numeric, minimum 0
- `stock`: required, integer, minimum 0

**Success Response (201):**
```json
{
    "success": true,
    "data": {
        "data": {
            "id": 2,
            "name": "New Product",
            "description": "Product description",
            "price": "99.99",
            "stock": 50,
            "user_id": 1,
            "status": "active",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        },
        "message": "Product created successfully"
    }
}
```

#### 3. Get Single Product
Retrieve a specific product by ID (requires 'view products' permission).

**Endpoint:** `GET /api/products/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "data": {
            "id": 1,
            "name": "Product Name",
            "description": "Product description",
            "price": "99.99",
            "stock": 10,
            "user_id": 1,
            "status": "active",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        },
        "message": "Product retrieved successfully"
    }
}
```

#### 4. Update Product
Update an existing product (requires 'edit products' permission).

**Endpoint:** `PUT /api/products/{id}` or `PATCH /api/products/{id}`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "name": "Updated Product Name",
    "description": "Updated description",
    "price": 149.99,
    "stock": 25
}
```

**Validation Rules:**
- `name`: sometimes required, string, max 255 characters
- `description`: optional, string
- `price`: sometimes required, numeric, minimum 0
- `stock`: sometimes required, integer, minimum 0

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "message": "Product updated successfully"
    }
}
```

#### 5. Delete Product
Delete a product (requires 'delete products' permission).

**Endpoint:** `DELETE /api/products/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "message": "Product deleted successfully"
    }
}
```

---

### Permission System

#### Roles
The system includes three default roles:

1. **Admin**
   - Full access to all products
   - Can manage users
   - All permissions granted

2. **Manager**
   - Can view and edit products
   - Limited user management

3. **User**
   - Can view products only
   - Basic access level

#### Permissions
- `view products`: View product listings and details
- `create products`: Create new products
- `edit products`: Update existing products
- `delete products`: Remove products
- `manage users`: User management operations

---

### Error Codes

| HTTP Status | Description |
|-------------|-------------|
| 200 | Success |
| 201 | Created successfully |
| 400 | Bad Request - Invalid input |
| 401 | Unauthorized - Invalid credentials |
| 403 | Forbidden - Insufficient permissions |
| 404 | Not Found - Resource doesn't exist |
| 422 | Unprocessable Entity - Validation errors |
| 500 | Internal Server Error |

---

### Example Usage Scenarios

#### 1. Complete Authentication Flow
```bash
# 1. Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "admin@example.com", "password": "password"}'

# Response: {"success": true, "data": {"token": "1|abc123...", "message": "Logged In successfully"}}

# 2. Use token for subsequent requests
curl -X GET http://localhost:8000/api/products \
  -H "Authorization: Bearer 1|abc123..."

# 3. Logout
curl -X POST http://localhost:8000/api/logout \
  -H "Authorization: Bearer 1|abc123..."
```

#### 2. Product Management Flow
```bash
# Create a product
curl -X POST http://localhost:8000/api/products \
  -H "Authorization: Bearer 1|abc123..." \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Laptop",
    "description": "High-performance laptop",
    "price": 999.99,
    "stock": 10
  }'

# Update the product
curl -X PUT http://localhost:8000/api/products/1 \
  -H "Authorization: Bearer 1|abc123..." \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Gaming Laptop",
    "price": 1299.99
  }'

# Delete the product
curl -X DELETE http://localhost:8000/api/products/1 \
  -H "Authorization: Bearer 1|abc123..."
```

---

### Notes

1. **Token Security**: Tokens are created with a unique name including email and timestamp for better tracking.

2. **Permission Checks**: All product operations include permission validation before execution.

3. **Data Validation**: All input data is validated according to the specified rules.

4. **Consistent Responses**: All endpoints use the CommonTrait for consistent response formatting.

5. **Laravel Sanctum**: Used for stateless API authentication with token-based security.

6. **Spatie Permission**: Provides robust role and permission management capabilities.

---

### Testing

Use Postman, Insomnia, or cURL for API testing.  
Example login request:

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "admin@example.com", "password": "password"}'
```

---

### License

MIT

---

*For questions or support, open an issue or contact the maintainer.*
