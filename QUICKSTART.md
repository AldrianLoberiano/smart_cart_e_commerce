# Quick Start Guide

## Prerequisites Check

Before starting, ensure you have:

- [ ] PHP 8.1+ installed (`php -v`)
- [ ] Composer installed (`composer --version`)
- [ ] Node.js 18+ installed (`node -v`)
- [ ] MySQL/PostgreSQL running
- [ ] Git installed

## 5-Minute Setup

### Step 1: Installation (2 minutes)

```bash
# Navigate to project
cd "SmartCart – Modern E-Commerce Web Application"

# Install dependencies (parallel execution)
composer install & npm install
```

### Step 2: Configuration (1 minute)

```bash
# Setup environment
cp .env.example .env
php artisan key:generate
```

Edit `.env` file - Update these 4 lines:

```env
DB_DATABASE=smartcart
DB_USERNAME=your_username
DB_PASSWORD=your_password
APP_URL=http://localhost:8000
```

### Step 3: Database Setup (1 minute)

```bash
# Create database (MySQL)
mysql -u root -p -e "CREATE DATABASE smartcart;"

# Run migrations with seed data
php artisan migrate --seed
```

### Step 4: Build & Run (1 minute)

```bash
# Terminal 1: Start Laravel
php artisan serve

# Terminal 2: Build assets (in new terminal)
npm run dev
```

### Step 5: Visit App

Open browser: `http://localhost:8000`

## Default Test Data

After seeding, you'll have:

- **8 Products** across 4 categories
- **4 Coupons** ready to use:
  - `WELCOME10` - 10% off first order
  - `SAVE20` - 20% off orders $100+
  - `FLAT50` - $50 off orders $200+
  - `FREESHIP` - Free shipping

## Common Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Reset database with fresh data
php artisan migrate:fresh --seed

# Production build
npm run build

# Run tests
php artisan test
```

## Troubleshooting

**"Class not found" error:**

```bash
composer dump-autoload
```

**Assets not loading:**

```bash
npm run build
php artisan storage:link
```

**Database connection failed:**

- Check MySQL is running
- Verify credentials in `.env`
- Ensure database exists

**Session not working:**

```bash
php artisan key:generate
php artisan cache:clear
```

## Next Steps

1. **Customize branding**: Edit `tailwind.config.js` colors
2. **Add payment gateway**: Configure Stripe keys in `.env`
3. **Setup email**: Configure mail driver in `.env`
4. **Add more products**: Use database seeders or admin panel

## File Structure Quick Reference

```
Key files you'll modify:
├── .env                          # Environment config
├── routes/web.php                # Add new routes
├── app/Http/Controllers/         # Create controllers
├── app/Models/                   # Define models
├── resources/views/              # Edit templates
├── resources/js/components/      # Alpine.js components
├── tailwind.config.js            # Customize styling
└── database/seeders/             # Sample data
```

## Support

- 📖 Full documentation: See `README.md`
- 🏗️ Architecture guide: See `ARCHITECTURE.md`
- 🐛 Found a bug? Create an issue
- 💡 Have questions? Check the docs first

---

**You're all set!** 🎉 Start building your e-commerce store.
