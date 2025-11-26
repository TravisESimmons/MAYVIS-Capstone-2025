# MAYVIS – Marketing Proposal Builder

A full-stack PHP/MySQL web application built as part of NAIT’s Capstone project.  
Originally created for a creative agency to streamline marketing proposal creation, review, and delivery.

This repository contains the full application, including the PHP backend, Tailwind-based UI, media handling, and complete SQL schema.

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
  <img src="resources/screenshots/landing-page.png" width="450"/>
</div>

### Client Dashboard
<div align="center">
  <img src="resources/screenshots/client-dashboard.png" width="450"/>
</div>

### Employee Dashboard
<div align="center">
  <img src="resources/screenshots/employee-dashboard.png" width="450"/>
</div>

---

## Features

### Proposal Management
- Create, edit, and manage multi-section marketing proposals
- Add project details, descriptions, pricing sections, and media items
- Save drafts and return later
- Generate final proposal output for client review

### User Roles
- **Clients** – Manage their proposals  
- **Employees** – Create, edit, and review proposals  
- **Admins** – Manage users and system configuration  

### Authentication & Accounts
- Secure login system  
- Role-based dashboards  
- Session handling with proper access control  

### Media Upload
- Add images and files to proposal sections  
- Server-side validation  
- Organized file storage and preview support  

### UI/UX Improvements
- Full Tailwind CSS redesign  
- Responsive layout for desktop and tablet  
- Streamlined navigation and improved workflow  

---

## Tech Stack

- **Frontend:** Tailwind CSS, JavaScript  
- **Backend:** PHP 8  
- **Database:** MySQL / MariaDB  
- **Web Server:** Apache  
- **Tools:** Git, XAMPP, phpMyAdmin  

---

## Database Setup

1. Ensure MySQL or MariaDB is running.  
2. Navigate to the `database/` directory.  
3. Import `schema.sql` into your SQL client.  
4. Confirm all tables were created successfully.

---

## Running the Application

### Clone the Repository
```bash
git clone https://github.com/TravisESimmons/MAYVIS-Capstone-2025.git
