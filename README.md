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

## Using Login api response will recives like this
- {
  "token": "78|sJYafhCY3oXpmQ5eF7OtITai0Qwxrhen37qJIWKP878f2d58",
  "user": {
    "id": 1,
    "name": "Kapil",
    "email": "kapil@gmail.com",
    "email_verified_at": null,
    "created_at": "2024-10-01T09:19:55.000000Z",
    "updated_at": "2024-10-01T09:19:55.000000Z"
  }
}
## Set token in auth Bearer Token in thunder client then all response will come using restfull api
## Note - login and register both are post api make sure for correct method while registering on login 
## all api will work after setting Bearer Token
