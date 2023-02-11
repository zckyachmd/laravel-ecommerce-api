# Laravel E-commerce API

Laravel E-commerce API
A RESTful API built with Laravel Framework for e-commerce applications. This API is designed to be used by a single page application (SPA) or mobile application as the backend.

## Features

-   Categories management (CRUD)
-   Products management (CRUD)
-   Categories search and filter
-   Products search and filter

## Prerequisites

-   PHP 8.0
-   Composer
-   Laravel >= 9.0
-   MySQL database
-   Postman

## Getting Started

1. Clone the repository

    > git clone https://github.com/zckyachmd/laravel-ecommerce-api.git

2. Install the dependencies

    > composer install

3. Create a copy of .env.example and rename it to .env. Then, configure the database information in the .env file.

4. Generate the application key

    > php artisan key:generate

5. Migrate the database

    > php artisan migrate

6. Run the application
    > php artisan serve

## API Endpoints

The API documentation can be accessed at [Postman](https://documenter.getpostman.com/view/16163112/2s935uFLAF) or import from file `Laravel-ECommerce-API.postman_collection.json` to Postman V2

Please adhere to this project's `code of conduct`.

## License

This project is licensed under the [MIT](https://choosealicense.com/licenses/mit/) License.
