## Docstore Backend

<p align="left">
  <img width="512" alt="Screenshot 2023-07-19 at 18 20 09" src="https://github.com/ivayloap/docstore_backend/assets/5279266/11dda3fa-fe61-4f3f-a035-60a0e2cc9325">
</p>


Docstore Backend is API for PDF File Storage with User Registration
This is a Laravel-based API project designed to store PDF files and provide user registration functionality. The project uses PostgreSQL as the database management system.

Installation
To set up the project locally, please follow these steps:

Clone the repository:

```shell
git clone git@github.com:ivayloap/docstore_backend.git
```

Navigate to the project directory:
```
cd docstore_backend
```

Install dependencies using Composer:
``` shell
composer install
```

Create a new PostgreSQL database for the project.
Copy the .env.example file to .env:

``` shell
cp .env.example .env
```

Update the .env file with your database credentials and configuration.

Generate an application key:

``` shell
php artisan key:generate
```
Run the database migrations:

``` shell
php artisan migrate
```

Start the development server:

``` shell
php artisan serve
```

You're ready to go! Access the API at http://localhost:8000.

Features
- User registration and authentication
- Securely store and manage PDF files
- Upload, retrieve, update, and delete PDF files
- API endpoints for user and file management
- Integration with PostgreSQL for robust data storage

Please refer to the project's API documentation for detailed information on the available endpoints and their usage.
