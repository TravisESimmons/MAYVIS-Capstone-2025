# MAYVIS – Marketing Proposal Builder

A full-stack PHP/MySQL web application built as part of NAIT’s Capstone project.  
Originally created for a creative agency to streamline marketing proposal creation, review, and delivery.

This repository contains the full application, including the PHP backend, Tailwind-based UI, media handling, and SQL schema.

---

## Overview

MAYVIS was developed by a three-person team.  
My contributions included:

- Designing and building the **entire SQL database schema**
- Rebuilding UI layouts using **Tailwind CSS**
- Refactoring legacy PHP into a more maintainable structure
- Fixing broken media upload logic and updating file-handling workflow
- Cleaning up inconsistent code and reorganizing the project for deployment
- Providing documentation and setup instructions

---

## Screenshots

### Landing Page
<div align="center">
  <img src="screenshots/landing-page.png" width="450"/>
</div>

### Client Dashboard
<div align="center">
  <img src="screenshots/client-dashboard.png" width="450"/>
</div>

### Employee Dashboard
<div align="center">
  <img src="screenshots/employee-dashboard.png" width="450"/>
</div>

---

## Features

### Proposal Management
- Create, edit, and manage multi-section marketing proposals  
- Add project details, pricing sections, descriptions, and media  
- Save drafts and return later  
- Generate a final proposal for client review  

### User Roles & Permissions
- **Clients** – review and manage their proposals  
- **Employees** – build and update proposals  
- **Admins** – manage system settings and users  

### Authentication
- Secure login  
- Role-based dashboard routing  
- Session handling  

### Media Upload
- Supports attaching images/files to proposal sections  
- Improved file validation and storage path management  
- Live previews for uploaded media  

### UI/UX Enhancements
- Full Tailwind CSS redesign  
- Modern, responsive layout  
- Better navigation flow and clarity  

---

## Tech Stack

- **Frontend:** Tailwind CSS, JavaScript  
- **Backend:** PHP 8  
- **Database:** MySQL / MariaDB  
- **Server:** Apache  
- **Tools:** Git, XAMPP, phpMyAdmin  

---

## Database Setup

1. Make sure MySQL or MariaDB is running.
2. Navigate to the `database/` directory.
3. Import `schema.sql` into your SQL client.
4. Confirm tables were created successfully.

---

## Running the Application

### Clone the Repository
```bash
git clone https://github.com/TravisESimmons/MAYVIS-Capstone-2025.git
