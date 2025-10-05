# Task Manager API
The Task Manager API is a RESTful backend application developed with Laravel and secured using Sanctum authentication.
It allows users to create, update, delete, and view their personal tasks, each with a title, description, and priority level.
Every user also has a personal profile containing contact details, a short bio, and a profile image.
Administrators have extended privileges, including viewing and managing all users and their tasks.

---

## Features
- User registration and login with **Laravel Sanctum**
- Role-based access control (**Admin / User**)
- Each user can:
  - Add, edit, delete, and view their own tasks
  - Manage their personal profile (name, phone, address, bio, profile image)
  - Set task priority and reorder tasks by importance
- Admin can:
  - View all users and their tasks
- RESTful JSON API responses
- Validation and error handling for secure and consistent data management

---

## Tech Stack
- **Backend:** Laravel 11  
- **Authentication:** Laravel Sanctum  
- **Database:** MySQL  
- **API Format:** REST (JSON)
