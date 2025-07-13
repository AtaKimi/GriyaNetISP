GriyaNetISP - A Management App for a Local ISP
GriyaNetISP is a web-based tool built to help a local Internet Service Provider (ISP) manage their customer data, service packages, and monthly billing. The system provides a centralized platform to track payments and customer information, effectively replacing manual, paper-based processes.

The Problem
Local ISPs often rely on manual methods like spreadsheets or physical ledgers to track customers and payments. This approach is prone to human error, inefficient for tracking payment statuses, and makes it difficult to get a real-time overview of the business's health. GriyaNetISP was built to solve these specific challenges.

Key Features
Dashboard: An informative main page providing a quick overview of key metrics, such as total customers, active packages, and recent payment activities.

Customer Management (CRUD): A complete module to Create, Read, Update, and Delete customer data, including personal information and installation addresses.

Service Package Management (CRUD): Administrators can easily add, edit, or remove internet service packages, including details like package name, speed, and price.

Monthly Billing System:

Administrators can view a comprehensive list of all customer bills for the current month.

Functionality to easily update the payment status of a bill from "Unpaid" to "Paid".

A clear and searchable history of all past billing records.

Interactive Data Tables: All data tables are equipped with search, sorting, and pagination features for easy data navigation, powered by the DataTables library.

Tech Stack
Back-End: PHP 8, Laravel 10

Front-End: Blade Templates, Bootstrap 5, JavaScript, jQuery

Database: MySQL

Development Tool: Vite

Version Control: Git

Screenshots
Dashboard Overview
(Replace this with a screenshot of your dashboard page)

Customer Management Page
(Replace this with a screenshot of the customer data table)

Billing Management Page
(Replace this with a screenshot of the monthly billing page)

Installation and Setup
To run this project locally, follow these steps:

Clone the repository:

git clone https://github.com/AtaKimi/GriyaNetISP.git
cd GriyaNetISP

Install PHP dependencies:

composer install

Install NPM dependencies:

npm install

Setup your environment file:

Copy the .env.example file to a new file named .env.

cp .env.example .env

Open the .env file and configure your database connection (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

Generate an application key:

php artisan key:generate

Run database migrations:

This will create all the necessary tables in your database.

php artisan migrate

(Optional) Seed the database with dummy data:

If you have created seeder files, run them to populate the database.

php artisan db:seed

Run the development server:

npm run dev

And in a separate terminal:

php artisan serve

The application should now be running on http://127.0.0.1:8000.
