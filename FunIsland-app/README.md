# FunIsland Tourism Platform

A comprehensive tourism booking platform built with Laravel 12, featuring hotel reservations, ferry bookings, and theme park tickets. The application includes role-based access control with separate interfaces for customers, management, and administrators.

## Features

- **Multi-Service Booking**: Hotels, ferries, and theme parks
- **Role-Based Access**: Customer, management, and admin interfaces
- **User Authentication**: Complete registration and login system with Laravel Breeze
- **Responsive Design**: Built with Tailwind CSS and Alpine.js
- **Database Management**: Comprehensive migration system with seeders

## Requirements

Before running this application, ensure you have the following installed:

- **PHP**: Version 8.2 or higher
- **Composer**: For PHP dependency management
- **Node.js**: Version 16 or higher
- **npm**: For frontend dependencies
- **Database**: SQLite (default) or MySQL/PostgreSQL
- **Web Server**: Apache/Nginx or use Laravel's built-in server

## Quick Start

### 1. Clone and Navigate
```bash
git clone <your-repository-url>
cd FunIsland-app
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file (create if doesn't exist)
cp .env.example .env
# OR create manually if .env.example doesn't exist
```

Create a `.env` file with the following basic configuration:
```env
APP_NAME="FunIsland"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack

DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite

# For MySQL (alternative):
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=funisland
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@funisland.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. Application Setup
```bash
# Generate application key
php artisan key:generate

# Create SQLite database file (if using SQLite)
touch database/database.sqlite

# Run database migrations
php artisan migrate

# Seed the database with initial data
php artisan db:seed
```

### 5. Build Frontend Assets
```bash
# For development (with file watching)
npm run dev

# For production (in separate terminal if needed)
npm run build
```

### 6. Start the Development Server
```bash
# Option 1: Laravel's built-in server
php artisan serve

# Option 2: Use the convenient dev script (runs server + queue + vite)
composer run dev

# Option 3: Manual setup (in separate terminals)
# Terminal 1: PHP server
php artisan serve

# Terminal 2: Frontend build watcher
npm run dev

# Terminal 3: Queue worker (if using queues)
php artisan queue:work
```

Visit [http://localhost:8000](http://localhost:8000) to access the application.

## Database Setup Options

### Option 1: SQLite (Default - Recommended for Development)
```bash
# Already configured in .env
touch database/database.sqlite
php artisan migrate
php artisan db:seed
```

### Option 2: MySQL
1. Create a MySQL database named `funisland`
2. Update your `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=funisland
DB_USERNAME=your_username
DB_PASSWORD=your_password
```
3. Run migrations:
```bash
php artisan migrate
php artisan db:seed
```

## User Roles and Access

The application includes three user roles:

1. **Customer**: Can browse and book services
2. **Management**: Can manage their respective services (hotels, ferries, theme parks)
3. **Admin**: Full system access and user management

Initial user accounts will be created through the seeder. Check the `RoleSeeder` for default credentials.

## Available Routes

- **Home**: `/` - Landing page
- **Browse Services**: 
  - `/browse/hotels` - Hotel listings
  - `/browse/ferries` - Ferry schedules
  - `/browse/themeparks` - Theme park tickets
- **Authentication**: `/login`, `/register`
- **Dashboard**: `/dashboard` - Role-based dashboard
- **Profile**: `/profile` - User profile management

## Development Commands

```bash
# Run tests
php artisan test
# OR
composer run test

# Clear application cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Generate IDE helper files (if installed)
php artisan ide-helper:generate

# Database operations
php artisan migrate:fresh --seed  # Reset and seed database
php artisan migrate:rollback      # Rollback last migration
php artisan db:wipe               # Drop all tables
```

## Project Structure

```
app/
├── Http/Controllers/     # Application controllers
├── Models/              # Eloquent models
├── View/Components/     # Blade components
database/
├── migrations/          # Database schema migrations
├── seeders/            # Database seeders
resources/
├── views/              # Blade templates
├── css/                # Stylesheets
└── js/                 # JavaScript files
routes/
├── web.php             # Web routes
└── auth.php            # Authentication routes
```

## Troubleshooting

### Common Issues

1. **Permission Errors**:
```bash
chmod -R 775 storage bootstrap/cache
```

2. **Missing Application Key**:
```bash
php artisan key:generate
```

3. **Database Connection Errors**:
   - Verify database credentials in `.env`
   - Ensure database exists (for MySQL/PostgreSQL)
   - Check file permissions for SQLite

4. **Frontend Assets Not Loading**:
```bash
npm run build
php artisan config:clear
```

5. **Class Not Found Errors**:
```bash
composer dump-autoload
```

## Production Deployment

For production deployment:

1. Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`
2. Configure proper database connection
3. Set up proper web server (Apache/Nginx)
4. Run `npm run build` for optimized assets
5. Configure proper mail settings
6. Set up SSL certificate
7. Configure proper file permissions

## Support

For issues and questions:
- Check Laravel documentation: [https://laravel.com/docs](https://laravel.com/docs)
- Review application logs in `storage/logs/`
- Ensure all requirements are met

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
