# MAYVIS
Welcome to NAIT Capstone's MAYVIS Project! This repository contains files to help you set up the necessary database tables and deploy PHP files on your server.

To use this project, you need:
- A web server with PHP support
- MySQL or MariaDB database server
- Git (optional, for cloning this repository.

### Setting up the Database

1. First, make sure you have a MySQL or MariaDB server installed and running.
2. Navigate to the `database/` directory.
3. Open `schema.sql` in your preferred SQL client.
4. Execute the SQL commands in your SQL client to create the necessary tables.

## Deploying PHP files
Clone the Repository:
If you have Git installed, you can clone the repository directly to your server's document root directory. Open a terminal or command prompt and run:
bash
Copy code
git clone https://github.com/DMIT-2590/Keen.git
Alternatively, you can download the ZIP file from the repository's GitHub page and extract it into your server's document root directory.
**Configure Web Server:**
Ensure that your web server (e.g., Apache, Nginx) is installed and properly configured to serve PHP files.
If you're using Apache, make sure mod_php or php-fpm is enabled.
For Nginx, ensure that PHP-FPM is installed and configured to handle PHP files.

Database Configuration:
Open the PHP files that interact with the database (e.g., connect.php, login/config/db.php) and ensure that the database connection settings (hostname, username, password, database name) match your server's configuration.
If necessary, create a new MySQL or MariaDB user with appropriate permissions to access the database.

Header Configuration:
# Mayvis Capstone 2024

A modern, full-featured proposal management web application built as a capstone project for Keen Creative.

## Overview

Mayvis is a web-based platform designed to streamline the creation, management, and approval of business proposals. The application features modern UI/UX, robust user authentication, and a responsive dashboard for both clients and employees.

## Features

- Modern, responsive design
- Client and employee dashboards
- Proposal creation, review, and approval workflows
- Template management
- User authentication and profile management
- Notification system
- Clean, maintainable PHP codebase

## Tech Stack

- **Frontend:** HTML5, CSS3 (custom and Bootstrap), JavaScript
- **Backend:** PHP 7+
- **Database:** MySQL
- **Other:** FontAwesome, jQuery

## Screenshots

### Client Dashboard
![Client Dashboard](screenshots/client-dashboard.png)

### Employee Dashboard
![Employee Dashboard](screenshots/employee-dashboard.png)

### Landing Page
![Landing Page](screenshots/landing-page.png)

## About

This project was developed as a capstone for Keen Creative by TravisESimmons, Evan Mah, Jeb Gallarde, and Melody Mirand. It demonstrates modern PHP development practices, UI/UX design, and full-stack web application architecture.
- Enter your root url (same as in header-new.php) in the $url string right before /login (line 29)
- Change the content in the "// creating email" and "//email content" sections with your email credentials. For the Password, create an app password using gmail. https://support.google.com/accounts/answer/185833?hl=en 
- The same thing must be done in the send-notification.php file under the send_to_client and proposal_update functions. Change the body messages as needed.
