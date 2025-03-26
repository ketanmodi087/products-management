# Product Management Frontend

A Vue 3 + TypeScript + Vite application for managing products. This frontend application works in conjunction with the Laravel backend API to provide a complete product management solution.

## Features

### Core Functionality
- Product listing with pagination, search, and sorting
- Add/Edit/Delete products with confirmation dialogs
- Real-time table updates
- Form validation and error handling

### User Interface
- Responsive design with modern SCSS styling
- Loading skeletons and toast notifications
- Modal forms and confirmation dialogs
- Auto-dismissing notifications (3s)

## Requirements

- Node.js (v16 or later)
- npm (v7 or later)

## Installation

1. Clone and navigate:
```sh
git clone https://github.com/ketanmodi087/products-management.git
cd products-management/FE
```

2. Install dependencies:
```sh
npm install
```

3. Configure environment:
- Create `.env` file
- Add: `VITE_APP_API_URL=http://127.0.0.1:8000/api`
> Note: Replace with your Laravel server URL

4. Start development server:
```sh
npm run dev
```

The application will be available at:
> http://localhost:5173

## Project Structure

```
FE/
├── src/
│   ├── assets/
│   │   ├── common-styles.scss
│   │   └── styles.scss
│   ├── components/
│   │   ├── ProductTable.vue
│   │   ├── ProductForm.vue
│   │   ├── ProductSkeleton.vue
│   │   ├── ErrorAlert.vue
│   │   ├── Notification.vue
│   │   └── DeleteConfirmation.vue
│   ├── App.vue
│   └── main.ts
├── package.json
└── vite.config.ts
```

## Available Scripts

- `npm run dev` - Start development server
- `npm run build` - Build for production
- `npm run preview` - Preview production build locally

## API Endpoints

- `GET /api/products` - Fetch products (with pagination, search, sorting)
- `POST /api/products` - Create product
- `PUT /api/products/{id}` - Update product
- `DELETE /api/products/{id}` - Delete product

## Development Guidelines

1. Follow Vue 3 Composition API patterns
2. Use TypeScript for type safety
3. Keep components modular and reusable
4. Follow established SCSS structure
5. Add confirmation dialogs for destructive actions
6. Implement proper error handling

## Troubleshooting

1. Verify backend API is running
2. Check API URL in `.env`
3. Clear cache and reinstall:
```sh
npm cache clean --force
rm -rf node_modules
npm install
```
