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

### User Authentication
- `POST /api/register`: Register a new user with name, email, password, and role (admin or user).
- `POST /api/login`: Authenticate user and get an access token for protected endpoints.
- `POST /api/logout`: Logout the authenticated user.
- `PUT /api/users`: Update the user profile with new information (for authenticated users only).
- `GET /api/users`: Get a list of all users (for authorized users only).
- `GET /api/users/{id}`: Get a specific user by ID (for authorized users only).

### Travel Packages
- `GET /api/travel`: Get a list of available travel packages with optional filters.
  - Query Parameters: `price`, `origin`, `destination`, `departure_time`.
- `GET /api/travel/{id}`: Get detailed information about a specific travel package.
- `POST /api/travel`: Add a new travel package (for authenticated users only).
- `PUT /api/travel/{id}`: Update a travel package (for authenticated users only).
- `DELETE /api/travel/{id}`: Delete a travel package (for authenticated users only).

### Booking
- `POST /api/bookings`: Book a travel package (for authenticated users only).
- `GET /api/bookings`: Get a list of user bookings (for authenticated users only).
- `DELETE /api/bookings/{id}`: Cancel a booked travel package (for authenticated users only).

### Payment
- `POST /api/payment/{id}`: Process payment for a travel booking using a Stripe token (for authenticated users only).


## Database Schema

### Table: users

| Column     | Type         | Nullable | Key     | Default | Extra          |
|------------|--------------|----------|---------|---------|----------------|
| id         | int(11)      | No       | Primary | None    | Auto Increment |
| name       | varchar(255) | No       | None    | None    |                |
| role       | boolean      | No       | None    | None    |                |
| email      | varchar(255) | No       | Unique  | None    |                |
| password   | varchar(255) | No       | None    | None    |                |
| created_at | timestamp    | No       | None    | None    |                |
| updated_at | timestamp    | No       | None    | None    |                |

### Table: travels

| Column         | Type          | Nullable | Key     | Default | Extra          |
|----------------|---------------|----------|---------|---------|----------------|
| id             | int(11)       | No       | Primary | None    | Auto Increment |
| price          | decimal(10,2) | No       | None    | None    |                |
| origin         | varchar(255)  | No       | None    | None    |                |
| destination    | varchar(255)  | No       | None    | None    |                |
| departure_time | datetime      | No       | None    | None    |                |
| user_id        | int(11)       | No       | Foreign | None    |                |
| is_available   | boolean       | No       | None    | 1       |                |
| created_at     | timestamp     | No       | None    | None    |                |
| updated_at     | timestamp     | No       | None    | None    |                |

### Table: bookings

| Column         | Type          | Nullable | Key     | Default | Extra          |
|----------------|---------------|----------|---------|---------|----------------|
| id             | int(11)       | No       | Primary | None    | Auto Increment |
| user_id        | int(11)       | No       | Foreign | None    |                |
| travel_id      | int(11)       | No       | Foreign | None    |                |
| status         | enum          | No       | None    | booked  |                |
| created_at     | timestamp     | No       | None    | None    |                |
| updated_at     | timestamp     | No       | None    | None    |                |



## Installation and Setup

1. Clone the repository: `git clone https://github.com/amrimuf/arjuno-travel`
2. Install PHP dependencies: `composer install`
3. Install Node.js dependencies: `npm install`
4. Configure the environment file: `cp .env.example .env`
5. Generate the application key: `php artisan key:generate`
6. Set up the database connection (and Stripe configuration) in the `.env` file.
7. Run database migrations: `php artisan migrate`
8. Compile assets with Tailwind CSS: `npm run dev`

## Usage

1. Start the development server: `php artisan serve`
2. Access the API documentation at `http://localhost:8000/api/documentation`

## Technologies Used

- PHP 8.1.6
- Laravel 10.10
- Tailwind CSS
- Stripe 10.18
- MySQL
- Swagger

## Credits

Arjuno Travel API is developed and maintained by [Amri Mufti](https://github.com/amrimuf).

## License

This project is open-source and available under the [MIT License](LICENSE). Feel free to use, modify, and distribute the code as needed.
