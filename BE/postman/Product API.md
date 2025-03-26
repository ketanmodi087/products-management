# Product API Documentation

## List Products (GET)
- URL: `http://localhost:8000/api/products`
- Method: `GET`
- Query Parameters:
  - `search` (optional): Search term for name or price
  - `sort_by` (optional): Field to sort by (`name` or `price`)
  - `sort_direction` (optional): Sort direction (`asc` or `desc`)
  - `page` (optional): Page number for pagination

Example URLs:
- Basic list: `http://localhost:8000/api/products`
- With search: `http://localhost:8000/api/products?search=laptop`
- With sorting: `http://localhost:8000/api/products?sort_by=price&sort_direction=desc`
- With pagination: `http://localhost:8000/api/products?page=2`

## Create Product (POST)
- URL: `http://localhost:8000/api/products`
- Method: `POST`
- Headers:
  - Content-Type: application/json
- Body (raw JSON):
```json
{
    "name": "Product Name",
    "price": 99.99
}
```

## Update Product (PUT)
- URL: `http://localhost:8000/api/products/{id}`
- Method: `PUT`
- Headers:
  - Content-Type: application/json
- Body (raw JSON):
```json
{
    "name": "Updated Product Name",
    "price": 149.99
}
```

## Delete Product (DELETE)
- URL: `http://localhost:8000/api/products/{id}`
- Method: `DELETE`
- No body required
