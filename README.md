# ReportIt - Community Service Reporting App

![ReportIt Logo](public/favicon.ico)

**ReportIt** is a modern, responsive web application designed to empower citizens by allowing them to easily report community issues (such as broken street lights, damaged roads, garbage accumulation, etc.) directly to local authorities. Authorities can track, manage, and update the status of these issues in real-time, fostering a cleaner and safer community.

---

## 🚀 Key Features

### For Citizens (Users)
- **Easy Issue Reporting:** Report issues with a title, category, description, and multiple image uploads.
- **Interactive Map Pinpointing:** Uses **Leaflet.js** and HTML5 Auto-Geolocation to automatically detect the user's location and allows drag-and-drop map pins for precise issue reporting.
- **Real-time Tracking:** Track the exact status of submitted requests (`Pending`, `In Progress`, `Resolved`, `Rejected`).
- **Authority Feedback:** View official notes and feedback provided by admins regarding specific issues.
- **Personal Dashboard:** A dedicated space to view and filter all past reports.

### For Authorities (Admins)
- **Admin Dashboard:** A comprehensive view of all reported issues across the community.
- **Status Management:** Quickly update the status of an issue to keep citizens informed.
- **Feedback System:** Add official notes to requests to explain resolutions or rejections.
- **Google Maps Integration:** Open the exact coordinates of an issue directly in Google Maps with a single click.
- **Spam Management:** Soft Delete functionality allows admins to reject and remove invalid or spam requests without permanently destroying database integrity.

---

## 🛠️ Technology Stack

This project is built using modern web development standards and follows a robust layered architecture.

**Backend & Architecture:**
- **Framework:** [Laravel 11.x](https://laravel.com) (PHP 8.2+)
- **Architecture:** MVC with a dedicated Service Layer (`ServiceRequestService`) for clean business logic.
- **Database & ORM:** MySQL with Eloquent ORM (including Spatial Data concepts for Coordinates).
- **Authentication:** Laravel Breeze

**Frontend:**
- **Reactivity:** [Livewire 3](https://livewire.laravel.com/) (Volt Components) & [Alpine.js](https://alpinejs.dev/)
- **Styling:** [Tailwind CSS](https://tailwindcss.com/)
- **Map Integration:** [Leaflet.js](https://leafletjs.com/) (OpenStreetMap)
- **Asset Bundler:** Vite

---

## 🏗️ System Architecture Highlights

1. **Service Layer Pattern:** Business logic (like saving images and handling coordinates) is abstracted into Service Classes, keeping Livewire components and Controllers extremely thin and clean.
2. **Event-Driven UI:** The map components communicate with the Livewire backend seamlessly using AJAX, ensuring a smooth Single Page Application (SPA) feel without full page reloads (`wire:navigate`).
3. **Mass Assignment & Casts:** Strict Eloquent `$fillable` arrays and Enum casting ensure data integrity and prevent security vulnerabilities like SQL injection.

---

## ⚙️ Installation & Setup

Follow these steps to set up the project locally:

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL Database

### Step-by-Step Guide

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/reportit-app.git
   cd reportit-app
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install Frontend dependencies:**
   ```bash
   npm install
   ```

4. **Environment Setup:**
   Copy the example environment file and generate an app key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Configuration:**
   Create a MySQL database named `reportit_db` (or your choice) and update your `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=reportit_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

7. **Storage Link:**
   Create a symbolic link for uploaded images to be publicly accessible:
   ```bash
   php artisan storage:link
   ```

8. **Run the Application:**
   You will need two terminal windows to run the frontend builder and backend server simultaneously:

   *Terminal 1 (Vite Dev Server):*
   ```bash
   npm run dev
   ```

   *Terminal 2 (Laravel Server):*
   ```bash
   php artisan serve
   ```

   Access the application at: `http://localhost:8000`

---

## 🔒 Security Vulnerabilities

If you discover a security vulnerability within this project, please report it immediately to the development team. All security vulnerabilities will be promptly addressed.

## 📄 License

This project is licensed under the [MIT License](LICENSE) - see the LICENSE file for details.
