📦 Inventory Management System

Laravel + Vue (Inertia) Intern Assignment

📝 Project Overview

This project is a simple inventory management web application built using Laravel 12, MySQL, Vue 3, and Inertia.js.
The system allows an authenticated user to manage inventory items, track stock additions and deductions, and view item history.

Authentication is provided by the Laravel Vue Starter Kit, so no custom authentication logic was implemented.

🎯 Features

User authentication (login & register – provided by Laravel Starter Kit)

Add inventory items (single or multiple)

Support for multiple measurement units (Kg, m, cm, units)

Deduct inventory quantities (single or multiple items)

Track inventory transaction history (additions & deductions)

Search inventory items by name

Clean and simple UI built with Vue & Tailwind CSS

🧱 Technology Stack

Backend: Laravel 12

Frontend: Vue 3 + Inertia.js

Database: MySQL

Authentication: Laravel Starter Kit (Vue)

Styling: Tailwind CSS

🗂 Database Design

items table

id	Primary key
name	Item name
unit	Measurement unit (kg, m, cm, units)
quantity	Current stock quantity
created_at	Timestamp
updated_at	Timestamp

items_transactions table

id	Primary key
item_id	Related inventory item
type	add / deduct
quantity	Quantity changed
created_at	Timestamp

📌 This structure allows accurate tracking of inventory history and ensures data consistency.

🔄 Application Flow

Authenticated user logs in

User adds or deducts inventory items

Each action creates a transaction record

Current stock is updated automatically

Item history can be viewed at any time

Items can be searched by name

🔐 Security Practices

Authentication middleware protects all inventory routes

Server-side validation for all inputs

Prevention of negative stock values

CSRF protection enabled by Laravel

No unauthorized access to inventory operations

🎨 UI / UX

Simple and clean layout

User-friendly forms and tables

Clear validation and feedback messages

Easy navigation between inventory, history, and actions

🧠 Design & Best Practices

MVC architecture

Eloquent ORM relationships

Form Request validation

Separation of concerns (backend & frontend)

RESTful routing

Reusable Vue components

⚙️ Setup Instructions
1️⃣ Clone the repository
git clone <repository-url>
cd inventory-app

2️⃣ Install dependencies
composer install
npm install

3️⃣ Environment setup
cp .env.example .env
php artisan key:generate


Configure database credentials in .env.

4️⃣ Run migrations
php artisan migrate

5️⃣ Run the application
npm run dev
php artisan serve


Visit: http://localhost:8000

📌 Assumptions

Single user system

No user management features required

Inventory quantities are managed centrally

📅 Duration

Completed within 2 days as per assignment requirements.

👨‍💻 Author

Malitha Malshan
Laravel / Vue JS Intern Assignment