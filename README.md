## Appointment Booking App

This is an Appointment Booking Application built with Laravel, Inertia.js, and Vue.js. It allows users to book appointments and provides an admin dashboard for managing bookings.

![image](https://github.com/user-attachments/assets/ac32cd50-1163-4196-ba44-360f3114292e)


## Features

- User authentication (Login, Register, Logout)
- Role-based access control (Users & Admins)
- Users can book appointments based on available time slots
- Admin dashboard to manage all bookings

## Prerequisites
Before setting up the project, ensure you have the following installed:
- PHP (>= 8.1)
- Composer (PHP Dependency Manager)
- Node.js (>= 16.x) & npm (>= 8.x)
- MySQL or any other supported database
- Git
- Laravel 

## Installation & Setup

## Clone the Repository
- git clone https://github.com/EBRUSTECH/appointmentBookingApp.git
- cd appointmentBookingApp

##  Install Dependencies
- composer install

Frontend (Vue.js with Inertia)
- npm install

## Set Up Environment Variables
- cp .env.example .env
- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=booking
- DB_USERNAME=root
- DB_PASSWORD=your_password


## Generate Application Key
- php artisan key:generate

## Raw Database file
- mysql database file is in project file with name: booking
- Create the database name: booking and
- Upload the database file

 ## OR
 
## Run Database Migrations
- php artisan migrate

## Run Development Server (Laravel)
- php artisan serve

## Run Development Server Frontend (Vue + Vite)
- npm run dev

## User Routes
- GET	/user-booking	(User dashboard to book appointments)
- POST	/book-slot	(Book a time slot)

## Admin Routes (Protected by Admin Middleware)
- GET	/admin-dashboard	(Admin dashboard to manage all bookings)
