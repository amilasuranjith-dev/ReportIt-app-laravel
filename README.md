# ReportIt - Community Service Reporting App

ReportIt is a web application built to help residents report local community issues—such as broken street lights, damaged roads, or uncollected garbage—directly to local authorities. Authorities can review, track, and update the status of each report in one place.

---

## Key Features

### For Citizens
- **Issue Reporting:** Submit reports with a title, category, description, and multiple photos.
- **Interactive Map:** Uses Leaflet.js and browser geolocation to detect your current location and let you drag a pin to mark the exact spot.
- **Status Tracking:** Follow the progress of submitted requests (`Pending`, `In Progress`, `Resolved`, `Rejected`).
- **Authority Feedback:** Read notes and updates left by admins on each report.
- **Personal Dashboard:** View and filter all of your past reports.

### For Admins
- **Admin Dashboard:** View and manage all community reports from a single dashboard.
- **Status Updates:** Change request statuses as work progresses.
- **Feedback Notes:** Add official notes to explain resolutions or rejections.
- **Google Maps Link:** Open the exact coordinates of a report directly in Google Maps.
- **Spam Management:** Soft-delete invalid or spam requests without permanently losing database records.

---

## Tech Stack

- **Backend:** Laravel 13.x (PHP 8.3+), with a dedicated Service Layer (`ServiceRequestService`)
- **Frontend:** Livewire 4.x (Volt Components), Alpine.js 3.x, Tailwind CSS 3.x
- **Maps:** Leaflet.js 1.9 (OpenStreetMap)
- **Database:** MySQL with Eloquent ORM
- **Authentication:** Laravel Breeze
- **Asset Bundler:** Vite 8.x

---

## Local Setup

### Prerequisites
- PHP 8.3 or higher
- Composer
- Node.js & NPM
- MySQL

### Installation Steps

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/reportit-app.git
   cd reportit-app
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install frontend dependencies:**
   ```bash
   npm install
   ```

4. **Set up environment variables:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure the database:**
   Create a MySQL database (for example, `reportit_app`) and update `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=reportit_app
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

6. **Run database migrations:**
   ```bash
   php artisan migrate
   ```

7. **Create the storage symlink:**
   This makes uploaded images accessible from the browser:
   ```bash
   php artisan storage:link
   ```

8. **Start the application:**
   Run the frontend and backend servers in two separate terminal windows:

   Terminal 1 (Vite):
   ```bash
   npm run dev
   ```

   Terminal 2 (Laravel):
   ```bash
   php artisan serve
   ```

   Open `http://localhost:8000` in your browser.

---

## License

This project is licensed under the [MIT License](LICENSE). See the `LICENSE` file for details.
