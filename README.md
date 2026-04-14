# 🏥 InterKlinik - Medical Clinic Management System

<div align="center">

![InterKlinik](https://img.shields.io/badge/InterKlinik-Medical%20Platform-0a6884?style=for-the-badge&logo=health)
![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-CSS-06B6D4?style=for-the-badge&logo=tailwindcss)

**A modern web application for managing medical clinic appointments, patient information, and doctor schedules with integrated Google Calendar synchronization.**

[Features](#-key-features) • [Tech Stack](#-tech-stack) • [Setup](#-quick-start) • [Project Analysis](#-project-analysis)

</div>

---

## 📋 Project Overview

**InterKlinik** is a **bachelor's degree project** that addresses the gap in Slovak healthcare digital infrastructure. This web application provides an integrated platform for online appointment management, eliminating the limitations found in existing clinic management solutions.

> 🎓 **Bachelor's Project** - Developed as a comprehensive solution for healthcare clinic digitalization

---

## 🎯 Key Features

### 💼 **Online Appointment Reservation System**
✅ **Smart Reservation with Multiple Filters:**
- 👨‍⚕️ Select doctor
- 📅 Choose available time slot
- 🏥 Pick medical service
- 💰 View real-time pricing

### 📊 **Patient Management**
- 👤 Complete patient health information storage
- 📱 Patient profile management
- 📋 Reservation history
- 🔒 Secure personal data handling

### 👨‍⚕️ **Doctor Dashboard**
- 📅 Availability term management
- 📖 Calendar view of appointments
- 🔔 Real-time notifications
- 📊 Reservation management

### 💳 **Pricing & Services Management**
- 💰 Dynamic price display during reservation
- 🔗 Price list integrated with booking system
- 🔍 Searchable service catalog
- 📝 Detailed service descriptions

### 🔔 **Notifications & Communication**
- 📧 Email notifications for reservations
- 📱 Real-time in-app notifications
- 🔄 Google Calendar synchronization
- ⚡ Instant doctor-patient communication

### 👥 **Role-Based Access Control**
- 🔐 **Patient Role** - Browse, book, manage appointments
- 👨‍⚕️ **Doctor Role** - Manage terms and appointments
- 🛠️ **Admin Role** - System administration and settings

---


## 🛠️ Tech Stack

### **Backend**
```
🔹 PHP 8.2+
🔹 Laravel 12.0 (Web Framework)
🔹 Eloquent ORM (Database)
🔹 Google Calendar API
🔹 OAuth 2.0 Authentication
```

### **Frontend**
```
🎨 Blade Templates (Templating)
🎨 Alpine.js 3.4 (JavaScript Framework)
🎨 Tailwind CSS 3.1 (Styling)
🎨 Vite 7.0 (Build Tool)
🎨 Axios 1.11 (HTTP Client)
```

### **Database**
```
💾 SQLite (Development)
💾 MySQL/PostgreSQL (Production)
💾 Laravel Migrations (Schema Management)
```

### **Development & Deployment**
```
🐳 Docker (Laravel Sail)
✅ PHPUnit (Testing)
📦 Composer (PHP Package Manager)
📦 npm (JavaScript Package Manager)
```

---

## ⚡ Quick Start

### Prerequisites
- **PHP** 8.2 or higher
- **Composer**
- **Node.js** & **npm**
- **Git**

### Installation

```bash
# 1. Clone the repository
git clone <repository-url>
cd clinic

# 2. Full setup (installs all dependencies & runs migrations)
composer setup

# 3. Start development servers (runs all servers concurrently)
composer dev

# 4. Access the application
# Open http://localhost:8000 in your browser
```

### Development Commands

```bash
# Frontend development with live reload
npm run dev

# Frontend production build
npm run build

# Run database migrations
php artisan migrate

# Run unit and feature tests
composer test

# View real-time application logs
php artisan pail

# Format code with Laravel Pint
php artisan pint

# Interactive shell (Tinker)
php artisan tinker
```

---

## 📁 Project Structure

```
clinic/
├── app/
│   ├── Http/
│   │   └── Controllers/          # Request handlers for routes
│   ├── Models/                   # Eloquent database models
│   │   ├── User.php
│   │   ├── Term.php
│   │   ├── Reservation.php
│   │   ├── Service.php
│   │   ├── Department.php
│   │   ├── Cabinet.php
│   │   └── PatientInfo.php
│   ├── Services/
│   │   └── GoogleCalendarService.php  # Google Calendar integration
│   └── Notifications/            # Email notification classes
│
├── resources/
│   ├── views/                    # Blade templates (HTML)
│   │   ├── layouts/              # Layout templates
│   │   ├── components/           # Reusable Blade components
│   │   ├── admin/                # Admin pages
│   │   ├── doctor/               # Doctor pages
│   │   └── user/                 # Patient pages
│   ├── js/                       # JavaScript files
│   │   ├── app.js                # Alpine.js initialization
│   │   └── bootstrap.js          # Axios setup
│   └── css/                      # Tailwind CSS
│
├── database/
│   ├── migrations/               # Database schema changes
│   ├── seeders/                  # Sample data generators
│   └── factories/                # Test data factories
│
├── routes/
│   ├── web.php                   # Web routes (user-facing)
│   ├── auth.php                  # Authentication routes
│   └── api.php                   # API routes
│
├── config/                       # Configuration files
│   ├── app.php                   # Application settings
│   ├── database.php              # Database configuration
│   ├── mail.php                  # Email configuration
│   ├── services.php              # Third-party services (Google)
│   └── auth.php                  # Authentication settings
│
└── tests/                        # Automated tests
    ├── Feature/                  # Feature tests
    └── Unit/                     # Unit tests
```

---

## 🔐 Key Features in Detail

### 👥 **Three-Role System**

#### **Patient Role** 👤
- Browse available doctors and medical services
- Check real-time appointment availability
- Book appointments with instant email confirmation
- Manage personal health information (patient info)
- View complete reservation history
- Connect Google Calendar for automatic event sync
- Receive appointment reminders

#### **Doctor Role** 👨‍⚕️
- Create and manage availability time slots (Terms)
- Set working hours, days off, and breaks
- View all upcoming patient reservations
- Manage appointment calendar
- Receive notifications for new bookings
- Manage offered services and pricing

#### **Admin Role** 🛠️
- User management (create, edit, delete users)
- Department management and configuration
- Cabinet (office/examination room) management
- Service catalog and pricing management
- System settings and configuration
- View activity logs and analytics

### 📅 **Appointment Booking Flow**

```
┌─────────────────────────────────────────────┐
│ 1. Patient browses doctors & services       │
└──────────────────┬──────────────────────────┘
                   ↓
┌─────────────────────────────────────────────┐
│ 2. Selects preferred date & time slot       │
└──────────────────┬──────────────────────────┘
                   ↓
┌─────────────────────────────────────────────┐
│ 3. Views real-time pricing information      │
└──────────────────┬──────────────────────────┘
                   ↓
┌─────────────────────────────────────────────┐
│ 4. Confirms and submits booking             │
└──────────────────┬──────────────────────────┘
                   ↓
┌─────────────────────────────────────────────┐
│ 5. Email confirmation sent to patient       │
└──────────────────┬──────────────────────────┘
                   ↓
┌─────────────────────────────────────────────┐
│ 6. If Google Calendar connected             │
│    → Event automatically created             │
└──────────────────┬──────────────────────────┘
                   ↓
┌─────────────────────────────────────────────┐
│ 7. Doctor receives notification             │
└─────────────────────────────────────────────┘
```

### 🔄 **Google Calendar Integration**

- 🔐 Secure OAuth 2.0 authentication
- 💾 Encrypted token storage in database
- 🔄 Automatic token refresh mechanism
- 📅 Bidirectional event synchronization
- ⚙️ Customizable event details and notifications

### 💾 **Database Schema (Key Tables)**

```
users                    - User accounts with roles
departments              - Medical departments
cabinets                 - Doctor offices/examination rooms
terms                    - Doctor availability slots
reservations             - Patient appointments
services                 - Medical services offered
patient_infos            - Patient health information
password_reset_tokens    - Password reset functionality
notifications            - User notifications
```

---

## 🚀 Deployment Ready

The application is configured for both development and production environments:

- ✅ Environment-based configuration (`.env` file)
- ✅ Database migration system for schema management
- ✅ Docker support via Laravel Sail
- ✅ Production-grade security features (encryption, CSRF protection)
- ✅ Scalable and maintainable architecture
- ✅ Error handling and logging system

### Production Requirements
- PHP 8.2+
- MySQL 8.0+ or PostgreSQL
- Node.js for asset compilation
- Secure SSL/TLS certificate
- Environment variables properly configured

---

## 📞 Documentation

For detailed technical information:

- 📖 [Tech Stack Overview](./TECH_STACK_OVERVIEW.md) - Complete technology stack details
- 📖 [Google Calendar Integration](./GOOGLE_CALENDAR_INTEGRATION.md) - Calendar setup guide
- 📖 [Laravel Documentation](https://laravel.com/docs) - Official Laravel docs
- 📖 [Tailwind CSS Documentation](https://tailwindcss.com/docs) - Tailwind utilities
- 📖 [Alpine.js Documentation](https://alpinejs.dev/) - Alpine directives

---

## 🎓 About This Project

**InterKlinik** was developed as a bachelor's thesis project addressing the need for modernized appointment management systems in Slovak healthcare. The project successfully demonstrates:

- ✅ Full-stack web application development
- ✅ Database design and optimization
- ✅ RESTful API principles
- ✅ User authentication and authorization
- ✅ Third-party API integration
- ✅ Responsive UI/UX design
- ✅ Testing and quality assurance

---

<div align="center">

### 🎓 Bachelor's Thesis Project

**InterKlinik** - Modernizing Healthcare Appointment Management  
*A Comprehensive Solution for Clinic Digitalization*

**Built with:** Laravel | Tailwind CSS | Alpine.js | Google Calendar API


</div>

