# ShopMVP API Implementation

This document provides an overview of the API implementation for the ShopMVP application.

## Overview

The API is built using Laravel 12 with Sanctum for authentication. It provides endpoints for:

- Authentication (register, login, logout, get current user)
- Products (list, show, filter by category, filter by shop)
- Categories (list, show, filter by shop)
- Shops (list, show, get by user)
- Orders (list, show, create, update, cancel, get details)

## Setup

1. Make sure you have Laravel 12 and Sanctum installed:
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

4. Configure CORS in `config/cors.php` to allow requests from your frontend domain.

## Testing the API

You can test the API using the provided Postman collection and environment:

1. Import `online-shop-api.postman_collection.json` into Postman
2. Import `online-shop-api.postman_environment.json` into Postman
3. Select the "ShopMVP API - Local" environment
4. Start testing the endpoints

### Authentication Flow

1. Register a new user using the Register endpoint
2. Login using the Login endpoint
3. The response will include a token - copy this token
4. In Postman, set the token variable in the environment to the copied token
5. You can now access authenticated endpoints

## API Documentation

For detailed API documentation, refer to `API_DOCUMENTATION.md`.

## Models

The API uses the following models:

- User: Represents a user of the application
- Product: Represents a product that can be ordered
- Category: Represents a category of products
- Shop: Represents a shop that sells products
- Order: Represents an order placed by a user
- OrderDetail: Represents a line item in an order

## Controllers

The API uses the following controllers:

- LoginController: Handles authentication
- ProductController: Handles product-related endpoints
- CategoryController: Handles category-related endpoints
- ShopController: Handles shop-related endpoints
- OrderController: Handles order-related endpoints

## Routes

All API routes are defined in `routes/api.php` and are prefixed with `/api`.
