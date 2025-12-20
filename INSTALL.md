# SmartCart - Installation Instructions

## Important: Initial Setup Required

This project contains all the custom code for SmartCart, but you need to install Laravel and its dependencies first.

## Step-by-Step Installation

### Option 1: Fresh Laravel Installation (Recommended)

```powershell
# 1. Create a new Laravel 10 project
composer create-project laravel/laravel smartcart-temp
cd smartcart-temp

# 2. Copy the vendor folder and core files to SmartCart project
# Copy these folders/files from smartcart-temp to your SmartCart directory:
#   - vendor/
#   - bootstrap/cache/ (create if not exists)
#   - storage/ (if not exists)

# 3. Navigate back to SmartCart directory
cd "../SmartCart – Modern E-Commerce Web Application"

# 4. Install dependencies
composer install
npm install

# 5. Set up environment
cp .env.example .env
php artisan key:generate

# 6. Configure database in .env file
# Edit DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 7. Run migrations with sample data
php artisan migrate --seed

# 8. Create storage link
php artisan storage:link

# 9. Build assets
npm run dev

# 10. Start server
php artisan serve
```

### Option 2: Install Dependencies Directly

```powershell
# 1. Navigate to project directory
cd "SmartCart – Modern E-Commerce Web Application"

# 2. Install Composer dependencies (this will install Laravel)
composer install

# 3. If you get errors about missing directories, create them:
mkdir storage\framework\cache\data -Force
mkdir storage\framework\sessions -Force
mkdir storage\framework\views -Force
mkdir storage\logs -Force
mkdir bootstrap\cache -Force

# 4. Install npm dependencies
npm install

# 5. Set up environment
if (!(Test-Path .env)) { Copy-Item .env.example .env }
php artisan key:generate

# 6. Configure your database in .env
# Update these values:
#   DB_DATABASE=smartcart
#   DB_USERNAME=your_username
#   DB_PASSWORD=your_password

# 7. Create the database (MySQL example)
# mysql -u root -p -e "CREATE DATABASE smartcart;"

# 8. Run migrations and seeders
php artisan migrate --seed

# 9. Create storage symlink
php artisan storage:link

# 10. Build frontend assets
npm run dev

# 11. Start the development server
php artisan serve
```

## Troubleshooting

### "Could not open input file: artisan"

This means Laravel hasn't been installed yet. Run:

```powershell
composer install
```

### "Class not found" errors

Run:

```powershell
composer dump-autoload
```

### Storage permission errors

Create the required directories:

```powershell
mkdir storage\framework\cache\data -Force
mkdir storage\framework\sessions -Force
mkdir storage\framework\views -Force
mkdir storage\logs -Force
mkdir bootstrap\cache -Force
```

### "No application encryption key"

Run:

```powershell
php artisan key:generate
```

### Database connection errors

1. Make sure MySQL/PostgreSQL is running
2. Create the database: `CREATE DATABASE smartcart;`
3. Check credentials in `.env` file

## Quick Verification

After installation, verify everything works:

```powershell
# Check Laravel is installed
php artisan --version

# Check database connection
php artisan migrate:status

# Check if assets compiled
Test-Path public\build\manifest.json
```

## What's Included

✅ All application code (models, controllers, services)
✅ Database migrations and seeders
✅ Frontend components (Alpine.js)
✅ Blade templates
✅ API routes
✅ Documentation

❌ Laravel framework (install via composer)
❌ Node modules (install via npm)
❌ Vendor packages (install via composer)

## Next Steps

Once installed:

1. Visit http://localhost:8000
2. Browse products and categories
3. Test the shopping cart
4. Try checkout process
5. Use coupon codes: WELCOME10, SAVE20, FLAT50

For detailed information, see [README.md](README.md).
