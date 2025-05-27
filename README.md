# Jammership

Jammership is a web application for organizing, managing, and participating in game jams. It supports two user roles: **Jammers** (participants) and **Jam Organizers** (jam creators).

## Live Demo

Visit the live website here: [jammership.free.nf](jammership.free.nf)
![Screenshot_2](https://github.com/user-attachments/assets/27bdd876-206c-4afc-b8f1-1a3a1224adad)

## Features

- **User Authentication & Roles**
  - Secure registration and login for both Jammers and Organizers
  - Session-based authentication with role-based access control

- **Game Jam Management**
  - Organizers can create, edit, and delete game jams
  - Upload custom thumbnails for jams
  - Set jam type (online or physical), start/end dates, and descriptions
  - Automatic status updates for jams (upcoming, active, ended) based on dates

- **Dashboard**
  - Personalized dashboard for all users
  - Organizers see all their jams and application counts
  - Jammers see all available jams and can apply to join

- **Applications**
  - Jammers can apply to open jams directly from the dashboard or jam details page
  - Organizers can view, accept, or reject applications for their jams
  - Application status is visible to both organizers and jammers

- **Account Management**
  - Users can update their email and change their password
  - Option to delete account (with all associated data removed)

- **Responsive UI**
  - Modern, mobile-friendly design using Bootstrap and custom CSS
  - Animated backgrounds and visually distinct buttons for actions

- **Security**
  - Prepared statements for all database queries to prevent SQL injection
  - Session management and access checks on all protected pages

- **Other Features**
  - Logout functionality from any page
  - Organizer dashboard with quick links to create jams and view applications
  - Jam details page with formatted dates, organizer info, and application button
  - Danger zone for account deletion

## Project Structure

- `public/` — All main user-facing pages (dashboard, jam details, account, etc.)
- `classes/` — Core PHP classes for database and jam management
- `api/` — JavaScript files for AJAX actions (login, logout, jam CRUD, applications)
- `assets/css/` — Custom styles for dashboard and authentication pages
- `includes/` — Shared header and footer files

## Getting Started

1. Clone the repository and set up your web server (e.g., Apache, Nginx).
2. Configure your database and update connection settings in `classes/database.php`.
3. Access the app via `index.php` — you will be redirected to login or dashboard as appropriate.

---
