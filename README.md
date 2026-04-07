# Garage Management System

A simple beginner-friendly full stack Garage Management System made with HTML, CSS, JavaScript, PHP, and MySQL.

## Folder Structure

```text
garage/
|-- index.php
|-- README.md
|-- frontend/
|   `-- assets/
|       |-- css/
|       |   `-- style.css
|       `-- js/
|           `-- validation.js
|-- backend/
|   |-- api/
|   |   `-- service_records.php
|   |-- auth/
|   |   |-- login.php
|   |   `-- logout.php
|   |-- config/
|   |   `-- db.php
|   |-- customers/
|   |   `-- index.php
|   |-- includes/
|   |   |-- auth_check.php
|   |   |-- footer.php
|   |   |-- header.php
|   |   `-- helpers.php
|   |-- services/
|   |   |-- bill.php
|   |   `-- index.php
|   |-- vehicles/
|   |   `-- index.php
|   `-- dashboard.php
`-- database/
    `-- schema.sql
```

## Features

- Login and logout using PHP sessions
- Customer management
- Vehicle management
- Service management
- Dashboard with quick metrics
- Bill generation with tax calculation
- Service records JSON API
- Bootstrap UI with custom styling
- JavaScript validation for forms

## How to Run in XAMPP or WAMP

1. Copy the project folder into `htdocs` for XAMPP or `www` for WAMP.
2. Start Apache and MySQL from the control panel.
3. Open `phpMyAdmin`.
4. Import the file [schema.sql](/c:/xampp/htdocs/garage/database/schema.sql).
5. Check [db.php](/c:/xampp/htdocs/garage/backend/config/db.php) and update username or password if needed.
6. Visit `http://localhost/garage/`.

## Default Login

- Username: `admin`
- Password: `admin123`

## REST API

- `http://localhost/garage/backend/api/service_records.php`
