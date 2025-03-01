# Sutharrsh HireMe - Job Hiring Platform

## Overview
Sutharrsh HireMe is a PHP-based job hiring platform that allows employers to post jobs and candidates to apply for them. It includes authentication, job management, and application tracking features.

## Directory Structure
```
└── sutharrsh-hireme/
    ├── action.php            # Handles various actions like job applications
    ├── composer.json         # Composer dependencies
    ├── composer.lock         # Composer lock file
    ├── db_connection.php     # Database connection setup
    ├── hireme.sql            # SQL schema for database setup
    ├── index.php             # Entry point of the application
    ├── services.php          # Services configuration
    ├── .htaccess             # URL rewriting rules
    ├── controllers/          # Controller files
    │   └── UserController.php
    ├── elements/             # UI elements
    │   └── Header.php
    ├── models/               # Database models
    │   ├── JobApplicationModel.php
    │   ├── JobModel.php
    │   └── UserModel.php
    ├── public/               # Public assets
    ├── services/             # Business logic services
    │   └── AuthService.php
    ├── vendor/               # Third-party dependencies (managed by Composer)
    ├── views/                # View templates
    │   ├── GetApplied.php
    │   ├── Profile.php
    │   ├── ProfileView.php
    │   ├── admin.php
    │   ├── forgot.php
    │   ├── home_view.php
    │   ├── login.php
    │   ├── logout.php
    │   ├── register_view.php
    │   ├── admin/
    │   │   └── index.php
    │   └── employeer/
    │       ├── AddJobs.php
    │       ├── GetJobs.php
    │       └── Showdata.php
```

## Installation & Setup

### 1. Clone the Repository
```sh
git clone https://github.com/yourusername/sutharrsh-hireme.git
cd sutharrsh-hireme
```

### 2. Install Dependencies
Make sure you have Composer installed, then run:
```sh
composer install
```

### 3. Configure Database
1. Import `hireme.sql` into your MySQL database.
2. Update `db_connection.php` with your database credentials.

### 4. Setup Local Server
Start a local PHP server with:
```sh
php -S localhost:8000
```
Then, open `http://localhost:8000` in your browser.

## Features
- User Authentication (Login, Register, Logout)
- Job Posting & Management
- Job Applications & Tracking
- Admin Panel
- Employer Dashboard

## Contributing
Feel free to fork this repository and submit pull requests to improve functionality.

## License
This project is licensed under [MIT License](LICENSE).

