# Product CRUD with Laravel & Vue.js

# Laravel Project Setup

This project is a Laravel 12-based API backend designed to work with a Vue frontend application. It provides API support for managing resources and includes a seeder to generate 100 random products for demo purposes.

## Requirements

Ensure you have the following installed:

- PHP 8.2 or later
- Composer
- MySQL
- XAMPP (recommended for local development)

## Installation Steps

### 1. Clone the Repository
```sh
git clone https://github.com/ketanmodi087/products-management.git
cd products-management/BE
```

### 2. Database Setup
1. Start your MySQL server (via XAMPP)
2. Create a new database named `laravel` in MySQL
   - You can create it using phpMyAdmin in XAMPP
   - Or using MySQL command line: `CREATE DATABASE laravel;`

### 3. Project Setup
1. Copy the `.env.example` file to `.env`:
```sh
cp .env.example .env
```

### 4. Install Dependencies
```sh
composer install
```

### 5. Generate Application Key
```sh
php artisan key:generate
```

### 6. Configure Environment
1. Open the `.env` file
2. Update the following variables:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Run Database Migrations & Seeders
This command will:
- Create all the required tables in the database
- Add 100 products for demo purposes
```sh
php artisan migrate --seed
```

### 8. Start the Laravel Server
This command will host the project in your local environment.
```sh
php artisan serve
```

The Laravel project setup is now complete. The following path can be used in your frontend project as the API base path:

> API Path:<br>
> http://127.0.0.1:8000/api

## API Endpoints

The following API endpoints are available:

### Products
- `GET /api/products` - List all products (with pagination, sorting, and search)
- `POST /api/products` - Create a new product
- `GET /api/products/{id}` - Get a specific product
- `PUT /api/products/{id}` - Update a product
- `DELETE /api/products/{id}` - Delete a product

## Project Structure

```
BE/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── ProductController.php
│   │   └── Requests/
│   │       └── ProductRequest.php
│   └── Models/
│       └── Product.php
├── database/
│   ├── migrations/
│   │   └── create_products_table.php
│   └── seeders/
│       └── ProductSeeder.php
└── routes/
    └── api.php
```

## Notes
- Ensure that your database is running before executing migrations
- The project uses Laravel's API resources for consistent JSON responses
- All API responses follow RESTful conventions
- The project includes input validation and error handling
- For any issues or support, please contact the development team

## Troubleshooting

If you encounter any issues:

1. Check if MySQL is running in XAMPP
2. Verify database credentials in `.env`
3. Clear Laravel cache:
```sh
php artisan config:clear
php artisan cache:clear
```
4. Check Laravel logs in `storage/logs/laravel.log`
