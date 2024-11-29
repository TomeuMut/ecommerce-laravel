
# Ecommerce Laravel

A Laravel-based e-commerce application with a RESTful API, user authentication, and database integration.

## Prerequisites
Before starting, ensure you have the following installed:
- **PHP** >= 8.0
- **Composer** (PHP dependency manager)
- **Docker** and **Docker Compose** (for database and phpMyAdmin containers)
- **Node.js** and **npm** (optional, for frontend assets)
- **Laravel CLI** (optional, for running Laravel commands)

---

## Installation

### 1. Clone the repository
```bash
git clone https://github.com/TomeuMut/ecommerce-laravel.git
cd ecommerce-laravel
```

### 2. Install PHP dependencies
```bash
composer install
```

### 3. Optional: Install frontend dependencies
```bash
npm install
npm run dev
```

### 4. Set up the environment file
Copy the example `.env` file and update it:
```bash
cp .env.example .env
```

Pon aqui tus credenciales que tu hayas puesto en el archivo docker-compose:
```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=ecommerce_laravel
DB_USERNAME=root
DB_PASSWORD=root
```

Generate the application key:
```bash
php artisan key:generate
```

---

## Docker Setup

Start the containers for MySQL and phpMyAdmin:
```bash
docker-compose up -d
```

---

## Database Setup

Run migrations and seed the database with initial data:
```bash
php artisan migrate --seed
```

---

## Running the Application

Start the development server:
```bash
php artisan serve
```

- Access the app at: [http://localhost:8000](http://localhost:8000)
- Access phpMyAdmin at: [http://localhost:8080](http://localhost:8080)  
  - **User:** `root`  
  - **Password:** `root`

---

## API Endpoints

### Products
- **GET** `/api/products`: List all products  
- **GET** `/api/products/{id}`: View product details  
- **POST** `/api/products`: Create a new product  
- **PUT** `/api/products/{id}`: Update a product  
- **DELETE** `/api/products/{id}`: Delete a product  
- **GET** `/api/products-random`: View a random product  

### Categories
- **GET** `/api/categories`: List all categories  
- **GET** `/api/categories/{id}`: View category details  
- **POST** `/api/categories`: Create a new category  
- **PUT** `/api/categories/{id}`: Update a category  
- **DELETE** `/api/categories/{id}`: Delete a category  

### Orders
- **POST** `/api/orders`: Create an order  
- **GET** `/api/orders/{id}`: View order details  
- **PUT** `/api/orders/{id}/cancel`: Cancel an order  
- **GET** `/api/orders/{id}/status`: Check order status  

---

## API Documentation
The API is documented with Swagger. Access the Swagger UI at:  
[http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

---

## Command for get products from external API.
```bash
php artisan command:get-apifake-products
```
---

## Notes
- **Authentication**: User authentication is implemented using Laravel Breeze.
- **Seed Data**: Includes preloaded categories and products for testing.
- **Testing Tools**: Use Postman to test the API.

---

## Troubleshooting

### MySQL connection error
- Ensure Docker containers are running (`docker-compose up -d`).
- Verify `.env` database credentials match `docker-compose.yml`.

### Command Errors
- Maybe if your local console gives you an error, what you have to do is run with "docker exec -it ecommerce_app" in front so that it detects the docker container.

- Example:
```bash
docker exec -it ecommerce_app php artisan migrate
```
### Missing database tables
- Run `php artisan migrate` to apply migrations.

### Cannot log in to phpMyAdmin
- Use `root` as both the username and password.

---
