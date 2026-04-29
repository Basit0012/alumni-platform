# 🎓 Alumni Platform

A modern, dynamic networking and community platform built with **Laravel 11**, **Tailwind CSS**, and **Blade**. Connect alumni, students, and admins in one centralized hub.

## ✨ Features

- **Role-Based Authentication:** Dedicated dashboards and access levels for Admins, Alumni, and Students.
- **Community Feed:** Share updates, post images, and engage with the community via comments and likes.
- **Alumni Directory:** Advanced search and filtering to find alumni by name, company, major, or graduation year.
- **Mentorship System:** Request, approve, or reject mentorships. Includes automated email notifications.
- **Connections:** Build your network by sending and accepting connection requests.
- **Event Management:** Admins can create in-person or online events. Users can seamlessly register/unregister.
- **Premium UI/UX:** Built with Tailwind CSS, featuring glassmorphism, responsive grids, and modern typography.

## 🚀 Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL (via XAMPP or similar)

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Basit0012/alumni-platform.git
   cd alumni-platform
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install and compile frontend dependencies:**
   ```bash
   npm install
   npm run build
   ```

4. **Environment Setup:**
   Copy the `.env.example` file and configure your database:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Make sure your MySQL server is running and update `DB_DATABASE` in `.env` to match your database name!*

5. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

6. **Start the local development server:**
   ```bash
   php artisan serve
   ```
   Visit `http://localhost:8000` in your browser.

## 🤖 Automation Scripts
This repository includes two bash scripts to automate Git operations:
- `bash push.sh`: Instantly stages, commits with a timestamp, and pushes to `main`.
- `bash watch-push.sh`: Auto-pushes changes every 10 seconds whenever a file is saved.
