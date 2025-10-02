# ShopMVP API Documentation

This document provides comprehensive documentation for the Laravel backend API endpoints required by the ShopMVP client application.

## Base URL

All API endpoints are relative to the base URL:

```
http://localhost:8000/api
```

For production, you should set the `NEXT_PUBLIC_API_URL` environment variable in the client application.

## Authentication

The API uses JWT (JSON Web Token) authentication. Most endpoints require authentication via a Bearer token in the Authorization header.

### Headers for authenticated requests

```
Authorization: Bearer {token}
Content-Type: application/json
Accept: application/json
```

## Error Handling

All endpoints return appropriate HTTP status codes:

- `200 OK`: Request successful
- `201 Created`: Resource created successfully
- `400 Bad Request`: Invalid request parameters
- `401 Unauthorized`: Authentication required or failed
- `403 Forbidden`: Authenticated but not authorized
- `404 Not Found`: Resource not found
- `422 Unprocessable Entity`: Validation errors
- `500 Server Error`: Server-side error

Error responses follow this format:

```json
{
  "message": "Error message",
  "errors": {
    "field_name": [
      "Error message for this field"
    ]
  }
}
```

## API Endpoints

### Authentication

#### Register

- **URL**: `/register`
- **Method**: `POST`
- **Authentication**: None
- **Request Body**:
  ```json
  {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "user_code": "OPTIONAL_CODE"
  }
  ```
- **Response**: `201 Created`
  ```json
  {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "user_code": "OPTIONAL_CODE",
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    },
    "token": "JWT_TOKEN_STRING"
  }
  ```

#### Login

- **URL**: `/login`
- **Method**: `POST`
- **Authentication**: None
- **Request Body**:
  ```json
  {
    "email": "john@example.com",
    "password": "password123"
  }
  ```
- **Response**: `200 OK`
  ```json
  {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "user_code": "OPTIONAL_CODE",
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    },
    "token": "JWT_TOKEN_STRING"
  }
  ```

#### Get Current User

- **URL**: `/user`
- **Method**: `GET`
- **Authentication**: Required
- **Response**: `200 OK`
  ```json
  {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "user_code": "OPTIONAL_CODE",
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z"
  }
  ```

#### Logout

- **URL**: `/logout`
- **Method**: `POST`
- **Authentication**: Required
- **Response**: `200 OK`
  ```json
  {
    "message": "Successfully logged out"
  }
  ```

### Products

#### Get All Products

- **URL**: `/products`
- **Method**: `GET`
- **Authentication**: Optional
- **Query Parameters**:
  - `category`: Filter by category ID
  - `shop`: Filter by shop ID
  - `search`: Search term for product name or description
  - `sort`: Sort order (newest, price_low, price_high, name_asc, name_desc)
  - `page`: Page number for pagination
  - `limit`: Number of items per page
- **Response**: `200 OK`
  ```json
  {
    "products": [
      {
        "id": 1,
        "name": "Premium Headphones",
        "description": "High-quality wireless headphones with noise cancellation",
        "price": 199.99,
        "discount": 10,
        "pics": ["/placeholder-product.jpg"],
        "video": "https://example.com/video.mp4",
        "types": ["Over-ear", "Wireless", "Noise-cancelling"],
        "colors": ["Black", "Silver", "Blue"],
        "stock": 15,
        "category_id": 1,
        "shop_id": 1,
        "created_at": "2023-01-01T00:00:00.000000Z",
        "updated_at": "2023-01-01T00:00:00.000000Z"
      }
    ],
    "total": 100,
    "page": 1,
    "limit": 10
  }
  ```

#### Get Product by ID

- **URL**: `/products/{id}`
- **Method**: `GET`
- **Authentication**: Optional
- **Response**: `200 OK`
  ```json
  {
    "id": 1,
    "name": "Premium Headphones",
    "description": "High-quality wireless headphones with noise cancellation",
    "price": 199.99,
    "discount": 10,
    "pics": ["/placeholder-product.jpg"],
    "video": "https://example.com/video.mp4",
    "types": ["Over-ear", "Wireless", "Noise-cancelling"],
    "colors": ["Black", "Silver", "Blue"],
    "stock": 15,
    "category_id": 1,
    "shop_id": 1,
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z"
  }
  ```

#### Get Products by Category

- **URL**: `/categories/{categoryId}/products`
- **Method**: `GET`
- **Authentication**: Optional
- **Query Parameters**: Same as Get All Products
- **Response**: Same format as Get All Products

#### Get Products by Shop

- **URL**: `/shops/{shopId}/products`
- **Method**: `GET`
- **Authentication**: Optional
- **Query Parameters**: Same as Get All Products
- **Response**: Same format as Get All Products

### Categories

#### Get All Categories

- **URL**: `/categories`
- **Method**: `GET`
- **Authentication**: Optional
- **Response**: `200 OK`
  ```json
  [
    {
      "id": 1,
      "name": "Electronics",
      "shop_id": 1,
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
  ]
  ```

#### Get Category by ID

- **URL**: `/categories/{id}`
- **Method**: `GET`
- **Authentication**: Optional
- **Response**: `200 OK`
  ```json
  {
    "id": 1,
    "name": "Electronics",
    "shop_id": 1,
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z"
  }
  ```

#### Get Categories by Shop

- **URL**: `/shops/{shopId}/categories`
- **Method**: `GET`
- **Authentication**: Optional
- **Response**: `200 OK`
  ```json
  [
    {
      "id": 1,
      "name": "Electronics",
      "shop_id": 1,
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
  ]
  ```

### Shops

#### Get All Shops

- **URL**: `/shops`
- **Method**: `GET`
- **Authentication**: Optional
- **Query Parameters**:
  - `search`: Search term for shop name or description
  - `page`: Page number for pagination
  - `limit`: Number of items per page
- **Response**: `200 OK`
  ```json
  {
    "shops": [
      {
        "id": 1,
        "name": "Tech Haven",
        "description": "Your one-stop shop for all things tech",
        "profile_pic": "/placeholder-shop.jpg",
        "social_links": {
          "facebook": "https://facebook.com/techhaven",
          "instagram": "https://instagram.com/techhaven"
        },
        "street": "123 Tech Street",
        "unit": "Suite 101",
        "address": "Silicon Valley, CA",
        "postal_code": "94000",
        "phone": "(123) 456-7890",
        "user_id": 1,
        "created_at": "2023-01-01T00:00:00.000000Z",
        "updated_at": "2023-01-01T00:00:00.000000Z"
      }
    ],
    "total": 50,
    "page": 1,
    "limit": 10
  }
  ```

#### Get Shop by ID

- **URL**: `/shops/{id}`
- **Method**: `GET`
- **Authentication**: Optional
- **Response**: `200 OK`
  ```json
  {
    "id": 1,
    "name": "Tech Haven",
    "description": "Your one-stop shop for all things tech",
    "profile_pic": "/placeholder-shop.jpg",
    "social_links": {
      "facebook": "https://facebook.com/techhaven",
      "instagram": "https://instagram.com/techhaven"
    },
    "street": "123 Tech Street",
    "unit": "Suite 101",
    "address": "Silicon Valley, CA",
    "postal_code": "94000",
    "phone": "(123) 456-7890",
    "user_id": 1,
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z"
  }
  ```

#### Get Shop by User

- **URL**: `/users/{userId}/shop`
- **Method**: `GET`
- **Authentication**: Required
- **Response**: `200 OK` (Same format as Get Shop by ID)

### Orders

#### Get All Orders (for authenticated user)

- **URL**: `/orders`
- **Method**: `GET`
- **Authentication**: Required
- **Response**: `200 OK`
  ```json
  [
    {
      "id": 1,
      "user_id": 1,
      "shop_id": 1,
      "order_number": "ORD-123456",
      "total_amount": 299.97,
      "status": "completed",
      "payment_status": "paid",
      "shipping_address": "123 Main St, Anytown, USA",
      "billing_address": "123 Main St, Anytown, USA",
      "payment_method": "credit_card",
      "shipping_method": "standard",
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z",
      "items": [
        {
          "id": 1,
          "order_id": 1,
          "product_id": 1,
          "product_name": "Premium Headphones",
          "quantity": 1,
          "price": 179.99,
          "total": 179.99,
          "created_at": "2023-01-01T00:00:00.000000Z",
          "updated_at": "2023-01-01T00:00:00.000000Z"
        }
      ]
    }
  ]
  ```

#### Get Order by ID

- **URL**: `/orders/{id}`
- **Method**: `GET`
- **Authentication**: Required
- **Response**: `200 OK` (Same format as single order in Get All Orders)

#### Create Order

- **URL**: `/orders`
- **Method**: `POST`
- **Authentication**: Required
- **Request Body**:
  ```json
  {
    "user_id": 1,
    "shop_id": 1,
    "total_amount": 299.97,
    "status": "pending",
    "payment_status": "pending",
    "shipping_address": "123 Main St, Anytown, USA",
    "billing_address": "123 Main St, Anytown, USA",
    "payment_method": "credit_card",
    "shipping_method": "standard",
    "order_details": [
      {
        "product_id": 1,
        "quantity": 1,
        "price": 179.99,
        "total": 179.99
      }
    ]
  }
  ```
- **Response**: `201 Created`
  ```json
  {
    "id": 1,
    "user_id": 1,
    "shop_id": 1,
    "order_number": "ORD-123456",
    "total_amount": 299.97,
    "status": "pending",
    "payment_status": "pending",
    "shipping_address": "123 Main St, Anytown, USA",
    "billing_address": "123 Main St, Anytown, USA",
    "payment_method": "credit_card",
    "shipping_method": "standard",
    "created_at": "2023-01-01T00:00:00.000000Z",
    "updated_at": "2023-01-01T00:00:00.000000Z",
    "items": [
      {
        "id": 1,
        "order_id": 1,
        "product_id": 1,
        "product_name": "Premium Headphones",
        "quantity": 1,
        "price": 179.99,
        "total": 179.99,
        "created_at": "2023-01-01T00:00:00.000000Z",
        "updated_at": "2023-01-01T00:00:00.000000Z"
      }
    ]
  }
  ```

#### Update Order

- **URL**: `/orders/{id}`
- **Method**: `PUT`
- **Authentication**: Required
- **Request Body**: Same format as Create Order (partial updates allowed)
- **Response**: `200 OK` (Same format as Get Order by ID)

#### Cancel Order

- **URL**: `/orders/{id}/cancel`
- **Method**: `POST`
- **Authentication**: Required
- **Response**: `200 OK`
  ```json
  {
    "message": "Order cancelled successfully",
    "order": {
      "id": 1,
      "status": "cancelled",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
  }
  ```

### Order Details

#### Get Order Details by Order ID

- **URL**: `/orders/{orderId}/details`
- **Method**: `GET`
- **Authentication**: Required
- **Response**: `200 OK`
  ```json
  [
    {
      "id": 1,
      "order_id": 1,
      "product_id": 1,
      "product_name": "Premium Headphones",
      "quantity": 1,
      "price": 179.99,
      "total": 179.99,
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
  ]
  ```

## Laravel Implementation Notes

### Database Schema

The API is designed to work with the following database schema:

1. **users** table:
   - id (primary key, auto-increment)
   - name
   - email
   - user_code
   - password
   - remember_token
   - timestamps (created_at, updated_at)

2. **categories** table:
   - id (primary key, auto-increment)
   - name
   - shop_id (foreign key)
   - timestamps (created_at, updated_at)

3. **products** table:
   - id (primary key, auto-increment)
   - name
   - description
   - price
   - discount
   - pics (JSON)
   - video
   - types (JSON)
   - colors (JSON)
   - stock
   - category_id (foreign key)
   - shop_id (foreign key)
   - timestamps (created_at, updated_at)

4. **shops** table:
   - id (primary key, auto-increment)
   - name
   - description
   - profile_pic
   - social_links (JSON)
   - street
   - unit
   - address
   - postal_code
   - phone
   - user_id (foreign key)
   - timestamps (created_at, updated_at)

5. **orders** table:
   - id (primary key, auto-increment)
   - user_id (foreign key)
   - shop_id (foreign key)
   - order_number (unique)
   - total_amount
   - status (pending/processing/completed/cancelled)
   - payment_status
   - shipping_address
   - billing_address
   - payment_method
   - shipping_method
   - timestamps (created_at, updated_at)

6. **order_details** table:
   - id (primary key, auto-increment)
   - order_id (foreign key)
   - product_id (foreign key)
   - product_name
   - quantity
   - price (price at the time of order)
   - total (quantity * price)
   - timestamps (created_at, updated_at)

### Authentication Setup

This API uses Laravel Sanctum for authentication. To set it up:

1. Install Laravel Sanctum:
   ```bash
   composer require laravel/sanctum
   ```

2. Publish the Sanctum configuration:
   ```bash
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   ```

3. Run migrations:
   ```bash
   php artisan migrate
   ```

4. Configure Sanctum in `config/sanctum.php` and set up CORS in `config/cors.php` to allow requests from your frontend domain.

### File Storage

For product images and shop profile pictures, configure Laravel's filesystem:

1. Set up the appropriate disk in `config/filesystems.php`
2. For public access, create a symbolic link:
   ```bash
   php artisan storage:link
   ```

### JSON Fields

For fields like `pics`, `types`, `colors`, and `social_links` that are stored as JSON:

1. Add these fields to the `$casts` property in your models:
   ```php
   protected $casts = [
       'pics' => 'array',
       'types' => 'array',
       'colors' => 'array',
       'social_links' => 'array',
   ];
   ```

### Order Number Generation

Implement a helper method to generate unique order numbers:

```php
public static function generateOrderNumber()
{
    $prefix = 'ORD-';
    $unique = false;
    $orderNumber = '';
    
    while (!$unique) {
        $orderNumber = $prefix . mt_rand(100000, 999999);
        $exists = Order::where('order_number', $orderNumber)->exists();
        if (!$exists) {
            $unique = true;
        }
    }
    
    return $orderNumber;
}
```

## Testing the API

You can test the API using tools like Postman or Insomnia. Here's a basic workflow:

1. Register a new user to get a token
2. Use the token in the Authorization header for subsequent requests
3. Test each endpoint with appropriate data

For automated testing, consider writing Laravel feature tests for each endpoint.