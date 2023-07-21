# Arjuno Travel API

Arjuno Travel API is a backend system for managing travel booking operations in "Arjuno Travel Booking Management System".

## Description

Arjuno Travel Booking Management System is designed to facilitate the booking of travel packages for customers. The API provides various endpoints for registering new users, handling authentication, managing travel details, and processing payments for travel bookings.

## Features

- User Registration: Register new users with basic information such as name, email, and password.
- User Login: Authenticate users with their email and password to access protected endpoints.
- Travel Listing: Get a list of available travel packages with options to filter by price, origin, destination, and departure time.
- Travel Details: Retrieve detailed information about a specific travel package.
- Travel Booking: Process payment for a travel booking and update the booking status to "paid".
- User Profile Update: Allow users to update their profile information such as name, email, and password.
- Travel Management: Allow authorized users to add, update, and delete travel packages.
- Error Handling: Proper error handling for various scenarios such as validation errors and resource not found.

## Endpoints

- `POST /api/register`: Register a new user with name, email, password, and role (admin or user).
- `POST /api/login`: Authenticate user and get an access token for protected endpoints.
- `GET /api/travel`: Get a list of available travel packages with optional filters.
- `GET /api/travel/{id}`: Get detailed information about a specific travel package.
- `POST /api/payment/{bookingId}`: Process payment for a travel booking using a Stripe token.
- `PUT /api/users`: Update the user profile with new information.
- `GET /api/users`: Get a list of all users (for authorized users only).
- `GET /api/users/{user}`: Get a specific user by ID (for authorized users only).
- `POST /api/travel`: Add a new travel package (for authorized users only).
- `PUT /api/travel/{id}`: Update a travel package (for authorized users only).
- `DELETE /api/travel/{id}`: Delete a travel package (for authorized users only).

## Installation and Setup

1. Clone the repository: `git clone https://github.com/amrimuf/arjuno-travel`
2. Install dependencies: `composer install`
3. Configure the environment file: `cp .env.example .env`
4. Generate application key: `php artisan key:generate`
5. Set up the database connection (and Stripe configuration) in the `.env` file.
6. Run database migrations: `php artisan migrate`

## Usage

1. Start the development server: `php artisan serve`
2. Access the API documentation at `http://localhost:8000/api/documentation`

## Technologies Used

- PHP 8.1.6
- Laravel 10.10
- Stripe 10.18
- MySQL
- Swagger

## Credits

Arjuno Travel API is developed and maintained by [Amri Mufti](https://github.com/amrimuf).

## License

This project is open-source and available under the [MIT License](LICENSE). Feel free to use, modify, and distribute the code as needed.
