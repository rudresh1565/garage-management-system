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
