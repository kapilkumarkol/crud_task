# Todo List RESTful API

This project is a Laravel-based RESTful API for managing a Todo List. It supports full CRUD operations (Create, Read, Update, Delete) for tasks, and includes token-based authentication for protected actions such as creating, updating, and deleting tasks. 

## Features

- **Task Model**: Includes `id`, `title`, `description`, `completed`, `created_at`, and `updated_at`.
- **API Endpoints**: Allows for the retrieval, creation, update, and deletion of tasks.
- **Validation and Error Handling**: Proper validation and graceful error handling.
- **Authentication**: Token-based authentication using Laravel Sanctum.

## Requirements

- PHP 8.2x or higher
- Composer
- Laravel 9.x or higher
- MySQL database supported by Laravel
- Postman (or similar tool) for API testing
- please pass authentication token in post man to retrive data

