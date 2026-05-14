# InterKlinik - Complete Tech Stack Overview

## 📋 PROJECT SUMMARY
**InterKlinik** is a medical clinic management system built with modern web technologies, featuring appointment/reservation management, Google Calendar integration, and role-based access control.

---

## 🔧 BACKEND STACK

### Framework & Core
- **PHP** `^8.2` - Programming language
- **Laravel Framework** `^12.0` - Full-stack web framework
  - Routing engine
  - Eloquent ORM
  - Database migrations
  - Task scheduling
  - Queue system
  - Notifications system
  - Authentication/Authorization

### Package Manager
- **Composer** - PHP dependency management

### Additional Backend Packages
- **google/apiclient** `^2.19` - Google APIs client library (for Calendar integration)
- **laravel/tinker** `^2.10.1` - Interactive REPL shell for testing

### Development & Testing Tools
- **PHPUnit** `^11.5.3` - Testing framework
- **Laravel Pint** `^1.24` - Code style fixer
- **Laravel Pail** `^1.2.2` - Log viewer
- **Laravel Sail** `^1.41` - Docker development environment
- **Mockery** `^1.6` - Mocking library for unit tests
- **FakerPHP** `^1.23` - Test data generator
- **Nunomaduro Collision** `^8.6` - Error handler

---

## 🎨 FRONTEND STACK

### Package Manager
- **npm/Node.js** - JavaScript package management

### Core Frontend Technologies
- **Blade** - Laravel's templating engine
- **Alpine.js** `^3.4.2` - Lightweight JavaScript framework
- **Tailwind CSS** `^3.1.0` - Utility-first CSS framework
- **Vite** `^7.0.7` - Modern frontend build tool

### Frontend Packages
- **@tailwindcss/forms** `^0.5.2` - Tailwind form components
- **@tailwindcss/vite** `^4.0.0` - Vite plugin for Tailwind CSS
- **laravel-vite-plugin** `^2.0.0` - Integration between Laravel and Vite
- **axios** `^1.11.0` - HTTP client for API requests
- **autoprefixer** `^10.4.2` - PostCSS plugin for vendor prefixes
- **postcss** `^8.4.31` - CSS transformation tool
- **concurrently** `^9.0.1` - Run multiple npm scripts concurrently

### Custom Styling
- Ocean-inspired color theme (custom Tailwind config)
- Shadow utilities with ocean theme

---

## 💾 DATABASE STACK

### Primary Database
- **SQLite** (default - `database/database.sqlite`)
  - File-based database, good for development

### Supported Databases (Configured but not necessarily active)
- **MySQL** `^8.0` - Relational database
- **MariaDB** - MySQL alternative
- **PostgreSQL** - Advanced relational database

### Database Tools
- **Migrations** - Schema version control
- **Seeders** - Sample data generation
- **Eloquent ORM** - Object-relational mapping

### Key Tables (Based on Models)
- `users` - User accounts with Google Calendar tokens
- `departments` - Medical departments
- `cabinets` - Doctor's offices/rooms
- `terms` - Doctor availability slots
- `reservations` - Patient appointments
- `services` - Medical services
- `patient_infos` - Patient information
- `password_reset_tokens` - Password reset functionality
- `cache` - Cache storage

---

## 📧 EMAIL & NOTIFICATIONS

### Email Services (Configured Options)
- **Log Driver** (default in development) - Logs emails to files
- **SMTP** - Standard mail protocol
- **Postmark** - Transactional email service
- **Resend** - Modern email API
- **AWS SES** - Amazon Simple Email Service
- **Sendmail** - System mail utility
- **Failover/Roundrobin** - Multi-provider redundancy

### Notification System
- Laravel Notifications (in-app)
- Email notifications for:
  - User creation
  - Department/Cabinet/Term creation
  - Reservation confirmations
  - Reservation cancellations (by doctor/patient)

---

## 🔐 AUTHENTICATION & SECURITY

### Authentication Methods
- **Laravel Breeze** `^2.3.0` - Lightweight authentication scaffolding
- Session-based authentication
- Password hashing (Laravel built-in)

### OAuth Integration
- **Google OAuth 2.0** - Third-party authentication
- Google Calendar API authentication tokens stored in database

### Security Features
- AES-256-CBC encryption for sensitive data
- Environment-based configuration (.env)
- CSRF protection
- Password reset tokens

---

## ☁️ CLOUD SERVICES & THIRD-PARTY APIs

### Google Cloud Services
- **Google Calendar API** `^2.19` (via google/apiclient)
  - Read/write access to patient calendars
  - OAuth 2.0 authentication
  - Token refresh mechanism
  - Event creation for confirmed reservations

### Configuration Files
- `config/services.php` - Third-party service credentials
  - Google Calendar client ID
  - Google Calendar client secret
  - Google Calendar redirect URI

---

## 🚀 DEVELOPMENT & DEPLOYMENT

### Development Commands
- `composer setup` - Full project setup
- `composer dev` - Run development servers concurrently:
  - PHP development server
  - Queue listener
  - Log viewer (Pail)
  - Vite build watcher
- `composer test` - Run PHPUnit tests
- `npm run dev` - Frontend development (Vite)
- `npm run build` - Production frontend build

### Build Tools
- **Vite** - Bundle JavaScript and CSS
- **PostCSS** - CSS processing
- **Tailwind CSS** - CSS compilation
- **Laravel Vite Plugin** - Asset management

### Docker Support
- **Laravel Sail** - Docker development environment

---

## 📁 PROJECT STRUCTURE

### Application Core (`/app`)
- `Http/Controllers/` - Request handlers
- `Models/` - Eloquent models (User, Term, Reservation, etc.)
- `Notifications/` - Notification classes
- `Services/` - Business logic (GoogleCalendarService)
- `Providers/` - Service providers
- `View/Components/` - Reusable view components

### Frontend Assets (`/resources`)
- `views/` - Blade templates
- `css/` - Tailwind CSS
- `js/` - Alpine.js and utilities

### Configuration (`/config`)
- `app.php` - Application settings
- `database.php` - Database connections
- `mail.php` - Mail configuration
- `services.php` - Third-party services
- `auth.php`, `cache.php`, `filesystems.php`, etc.

### Database (`/database`)
- `migrations/` - Schema changes
- `seeders/` - Sample data
- `factories/` - Test data generation

### Testing (`/tests`)
- Feature tests
- Unit tests

### Routes (`/routes`)
- `web.php` - Web routes (user-facing)
- `api.php` - API routes (if applicable)
- `auth.php` - Authentication routes
- `console.php` - Artisan commands

---

## 🔄 INTEGRATION HIGHLIGHTS

### Key Workflows
1. **Reservation Confirmation Flow**
   - Doctor confirms reservation
   - Email sent to patient (via Mail system)
   - If patient has Google Calendar connected:
     - Event automatically created in patient's Google Calendar
     - Event includes: time, doctor, service, department, room

2. **Google Calendar Connection**
   - Patient initiates OAuth flow
   - Redirected to Google consent screen
   - Tokens stored encrypted in database
   - Automatic token refresh on expiration

3. **Term Management**
   - Doctor creates/edits availability slots (Terms)
   - Conflict detection (same doctor or cabinet)
   - Calendar view for scheduling
   - Notifications on creation

---

## 📊 ENVIRONMENT VARIABLES (Key Ones)

```
# Application
APP_NAME=InterKlinik
APP_ENV=local|production
APP_DEBUG=true|false
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=sqlite|mysql|pgsql
DB_DATABASE=database.sqlite (or connection string)

# Mail
MAIL_MAILER=log|smtp|postmark|resend
MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD

# Google Calendar
GOOGLE_CALENDAR_CLIENT_ID=xxx
GOOGLE_CALENDAR_CLIENT_SECRET=xxx
GOOGLE_CALENDAR_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

---

## 🎯 MODERN BEST PRACTICES USED

✅ **MVC Architecture** - Clean separation of concerns  
✅ **ORM** - Database abstraction with Eloquent  
✅ **Migrations** - Version-controlled schema  
✅ **Testing** - PHPUnit with Mockery  
✅ **Authentication** - Secure session management  
✅ **API Integration** - OAuth 2.0 with Google  
✅ **Responsive Design** - Tailwind CSS + Alpine.js  
✅ **Modular Frontend** - Vite bundler  
✅ **Task Automation** - Concurrent script execution  
✅ **Environment Configuration** - .env-based configuration  

---

## 📋 QUICK REFERENCE TABLE

| Category | Technology | Version | Purpose |
|----------|-----------|---------|---------|
| **Language** | PHP | 8.2+ | Backend |
| **Framework** | Laravel | 12.0+ | Web framework |
| **Frontend** | Blade + Alpine.js | - | Templating & interactivity |
| **Styling** | Tailwind CSS | 3.1+ | CSS framework |
| **Build Tool** | Vite | 7.0+ | Asset bundling |
| **Database** | SQLite/MySQL | - | Data storage |
| **ORM** | Eloquent | (Laravel) | Database abstraction |
| **Package Mgmt** | Composer | - | PHP dependencies |
| **Package Mgmt** | npm | - | JavaScript dependencies |
| **Testing** | PHPUnit | 11.5+ | Unit/Feature tests |
| **Google APIs** | google-api-client | 2.19+ | Google Calendar |
| **Email** | Laravel Mail | (built-in) | Email sending |
| **HTTP Client** | Axios | 1.11+ | API requests |
| **Docker** | Laravel Sail | 1.41+ | Dev environment |

---

## 🔗 USEFUL COMMANDS

```bash
# Setup
composer setup
npm install

# Development
composer dev          # Run all servers
npm run dev          # Frontend watch
npm run build        # Production build

# Database
php artisan migrate  # Run migrations
php artisan seed     # Run seeders

# Testing
composer test        # Run PHPUnit
php artisan test     # Alternative

# Code Quality
php artisan pint     # Format code

# Logs
php artisan pail     # View logs

# Tinker (Interactive)
php artisan tinker   # REPL shell
```

---

**Last Updated:** April 2026  
**Application Name:** InterKlinik  
**Type:** Medical Clinic Management System

