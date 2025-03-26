# Product Management Application

A full-stack product management application built with Laravel 12 (Backend) and Vue.js 3 (Frontend).

## Project Structure

```
products-app/
├── BE/                 # Laravel Backend
│   ├── app/           # Application code
│   ├── database/      # Database migrations and seeders
│   └── README.md      # Backend specific instructions
│
└── FE/                # Vue.js Frontend
    ├── src/          # Source code
    ├── public/       # Public assets
    └── README.md     # Frontend specific instructions
```

## Requirements

### Backend Requirements
- PHP 8.2 or higher
- Composer
- MySQL 8.0 or higher
- XAMPP (recommended for local development)
- Git

### Frontend Requirements
- Node.js v16 or later
- npm v7 or later

## Installation Steps

### 1. Clone the Repository
```bash
git clone https://github.com/ketanmodi087/products-management.git
cd products-management
```

### 2. Backend Setup (Laravel)

1. Navigate to the backend directory:
```bash
cd BE
```

2. Install PHP dependencies:
```bash
composer install
```

3. Create and configure environment file:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=products_db
DB_USERNAME=root
DB_PASSWORD=
```

5. Create the database:
   - Using phpMyAdmin:
     1. Open phpMyAdmin (http://localhost/phpmyadmin)
     2. Click "New" to create a new database
     3. Enter "products_db" as the database name
     4. Click "Create"

   - Using MySQL command line:
```bash
mysql -u root -p
CREATE DATABASE products_db;
exit;
```

6. Run migrations and seed the database:
```bash
php artisan migrate --seed
```

7. Start the Laravel development server:
```bash
php artisan serve
```

The backend API will be available at: http://localhost:8000/api

### 3. Frontend Setup (Vue.js)

1. Navigate to the frontend directory:
```bash
cd FE
```

2. Install Node.js dependencies:
```bash
npm install
```

3. Create and configure environment file:
```bash
cp .env.example .env
```

4. Update the API URL in `.env`:
```env
VITE_APP_API_URL=http://localhost:8000/api
```

5. Start the development server:
```bash
npm run dev
```

The frontend application will be available at: http://localhost:5173

## Features

### Backend Features
- RESTful API endpoints for product management
- Database migrations and seeders
- Input validation
- Error handling
- CORS configuration
- API authentication (if implemented)

### Frontend Features
- Product listing with pagination
- Search functionality
- Sorting by columns
- Add/Edit/Delete products
- Form validation
- Success/Error notifications
- Responsive design
- Modern UI with SCSS styling

## API Endpoints

- `GET /api/products` - List all products
- `POST /api/products` - Create a new product
- `GET /api/products/{id}` - Get a single product
- `PUT /api/products/{id}` - Update a product
- `DELETE /api/products/{id}` - Delete a product

## Troubleshooting

### Backend Issues
1. If you encounter database connection issues:
   - Verify MySQL is running
   - Check database credentials in `.env`
   - Ensure database exists

2. If migrations fail:
   - Clear Laravel cache: `php artisan cache:clear`
   - Clear config cache: `php artisan config:clear`
   - Try running migrations again

### Frontend Issues
1. If API calls fail:
   - Verify backend server is running
   - Check API URL in `.env`
   - Ensure CORS is properly configured

2. If dependencies are missing:
   - Delete `node_modules` folder
   - Delete `package-lock.json`
   - Run `npm install` again

## Development Notes

- The backend uses Laravel 12 with PHP 8.2
- The frontend uses Vue.js 3 with TypeScript
- SCSS is used for styling
- The application follows RESTful API conventions
- All API responses are in JSON format