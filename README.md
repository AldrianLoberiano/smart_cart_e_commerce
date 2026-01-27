#  SmartCart E-Commerce Platform

A modern, feature-rich e-commerce platform built with Laravel, Alpine.js, and Tailwind CSS. SmartCart provides a seamless shopping experience with real-time stock management, secure payment processing, and a beautiful, responsive UI.

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat-square&logo=php)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=flat-square&logo=alpine.js)

---

##  Features

###  Customer Features
- **Modern UI/UX** - Beautiful, responsive design with gradient themes and smooth animations
- **Product Browsing** - Advanced filtering, sorting, and search capabilities
- **Real-time Stock Updates** - Live stock monitoring with visual progress bars
- **Shopping Cart** - Session-based cart with slide-out sidebar
- **Secure Checkout** - Stripe payment integration with order management
- **User Accounts** - Profile management, order history, and wishlist
- **Product Reviews** - Rate and review purchased products
- **Responsive Design** - Optimized for mobile, tablet, and desktop

### 🔧 Admin Features
- **Product Management** - CRUD operations with image upload
- **Order Management** - Track and update order statuses
- **Category Management** - Organize products into categories
- **Coupon System** - Create and manage discount codes
- **User Management** - View and manage customer accounts
- **Stock Tracking** - Real-time inventory monitoring

###  Technical Features
- **Real-time Stock Management** - Automatic stock updates with low stock alerts
- **API Integration** - RESTful API for cart and stock operations
- **Service Layer Architecture** - Clean separation of concerns
- **Session Management** - Secure session handling for guests and users
- **Database Optimization** - Efficient queries with eager loading
- **Payment Processing** - Stripe integration for secure transactions

---

##  Tech Stack

### Backend
- **Laravel 10.x** - PHP Framework
- **MySQL** - Database
- **Stripe** - Payment Processing

### Frontend
- **Blade Templates** - Server-side rendering
- **Alpine.js** - Reactive components
- **Tailwind CSS** - Utility-first styling
- **Vite** - Asset bundling

### Additional Tools
- **Intervention Image** - Image processing
- **Laravel IDE Helper** - Development tools
- **Composer** - Dependency management
- **NPM** - Frontend package management

---

##  Requirements

- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL 5.7+ or MariaDB
- Stripe Account (for payment processing)

---

##  Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd smart_cart_e_commerce
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database
Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smart_cart
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Configure Stripe
Add your Stripe keys to `.env`:
```env
STRIPE_KEY=your_stripe_publishable_key
STRIPE_SECRET=your_stripe_secret_key
```

### 6. Run Migrations & Seeders
```bash
# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

### 7. Build Frontend Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 8. Start Development Server
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

---

## 👤 Default Credentials

### Admin Account
- **Email:** admin@smartcart.com
- **Password:** admin123

### Test User Account
- Create your own account through registration
- Or seed test users with: `php artisan db:seed --class=UserSeeder`

---

##  Project Structure

```
smart_cart_e_commerce/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Request handlers
│   │   └── Middleware/      # HTTP middleware
│   ├── Models/              # Eloquent models
│   └── Services/            # Business logic layer
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── public/                  # Public assets
├── resources/
│   ├── css/                 # Stylesheets
│   ├── js/                  # JavaScript files
│   └── views/               # Blade templates
├── routes/
│   ├── web.php             # Web routes
│   └── api.php             # API routes
├── storage/                 # Application storage
└── vendor/                  # Composer dependencies
```

---

##  Key Services

### CartService
Handles all shopping cart operations:
- Add/remove items
- Update quantities
- Calculate totals
- Apply coupons

### OrderService
Manages order processing:
- Order creation
- Stock management
- Payment processing
- Order status updates

### ProductService
Product-related operations:
- Inventory management
- Stock tracking
- Low stock alerts

### StripePaymentService
Payment processing:
- Payment intent creation
- Charge processing
- Webhook handling

---

##  UI Components

### Reusable Components
- **Product Card** - Display product information with add-to-cart
- **Cart Sidebar** - Slide-out shopping cart
- **Stock Monitor** - Real-time stock level display
- **Rating Stars** - Product review ratings
- **Breadcrumb** - Navigation breadcrumbs

### Layout Features
- **Gradient Themes** - Modern gradient backgrounds
- **Hover Effects** - Smooth transitions and transformations
- **Responsive Grid** - Mobile-first responsive layouts
- **Shadow Effects** - Depth and elevation using shadows
- **Icon Integration** - SVG icons for better UX

---

##  Security Features

- **CSRF Protection** - Laravel's built-in CSRF tokens
- **Password Hashing** - Bcrypt password encryption
- **SQL Injection Prevention** - Eloquent ORM protection
- **XSS Protection** - Blade template escaping
- **Session Security** - Secure session management
- **Payment Security** - PCI-compliant Stripe integration

---

##  Database Schema

### Main Tables
- **users** - Customer accounts
- **admins** - Administrator accounts
- **products** - Product catalog
- **categories** - Product categories
- **orders** - Order records
- **order_items** - Order line items
- **cart_items** - Shopping cart items
- **reviews** - Product reviews
- **coupons** - Discount coupons
- **wishlists** - User wishlists

---

##  API Endpoints

### Cart API
```
POST   /api/cart/add          # Add item to cart
POST   /api/cart/update       # Update item quantity
DELETE /api/cart/remove/{id}  # Remove item from cart
GET    /api/cart              # Get cart contents
```

### Stock API
```
GET /api/product-stock/{id}   # Get current stock level
```

---

##  Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

---

##  Configuration Files

### Key Configuration
- `config/shop.php` - Shop settings (currency, tax, shipping)
- `config/services.php` - Third-party services (Stripe)
- `config/session.php` - Session configuration
- `.env` - Environment variables

---

##  Key Features Highlight

### Real-time Stock Management
- Live stock updates every 5 seconds
- Visual progress bars showing stock levels
- Low stock warnings with color-coded badges
- Automatic inventory tracking on orders

### Modern UI Design
- Gradient-based color schemes
- Smooth hover animations and transitions
- Card-based layouts with shadows
- Responsive mobile-first design
- Intuitive user interface

### Secure Payment Processing
- Stripe integration for credit card payments
- PCI-compliant payment handling
- Secure checkout process
- Order confirmation emails

---

##  Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

##  Troubleshooting

### Common Issues

**Database connection error:**
- Verify `.env` database credentials
- Ensure MySQL service is running
- Check database exists: `CREATE DATABASE smart_cart;`

**Assets not loading:**
- Run `npm run build` for production
- Clear cache: `php artisan cache:clear`
- Check file permissions on `public/` directory

**Stripe payment not working:**
- Verify Stripe keys in `.env`
- Check webhook configuration
- Ensure test mode keys for development

---

##  Support

For support, please:
- Open an issue on GitHub
- Check existing documentation
- Review Laravel documentation at [laravel.com](https://laravel.com)

---

##  Acknowledgments

- Built with [Laravel](https://laravel.com)
- UI powered by [Tailwind CSS](https://tailwindcss.com)
- Interactivity with [Alpine.js](https://alpinejs.dev)
- Payment processing by [Stripe](https://stripe.com)

---

##  Screenshots

### Home Page
Modern hero section with featured products and categories

### Product Listing
Advanced filtering and sorting with real-time stock indicators

### Product Detail
Comprehensive product information with reviews and related products

### Shopping Cart
Intuitive cart management with quantity controls

### User Account
Profile management, order history, and personal settings

---

**Made with ❤️ for modern e-commerce**

*SmartCart - Your Smart Shopping Destination*
