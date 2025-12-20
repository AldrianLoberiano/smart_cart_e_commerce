# SmartCart - Modern E-Commerce Web Application

A full-featured, modern e-commerce platform built with Laravel 10 and Alpine.js, featuring a clean architecture, responsive design, and seamless user experience.

## 🚀 Features

### Core Features

- **Product Management**: Complete product catalog with categories, filtering, and search
- **Shopping Cart**: Session-based cart with real-time updates using Alpine.js
- **Checkout Process**: Multi-step checkout with shipping and payment information
- **Order Management**: Order tracking, status updates, and order history
- **User Authentication**: Laravel Breeze authentication system
- **Reviews & Ratings**: Customer reviews with verified purchase badges
- **Coupon System**: Flexible discount system (percentage & fixed)
- **Wishlist**: Save favorite products for later

### Technical Features

- **Alpine.js Components**: Reactive cart, quantity selectors, modals, and search
- **Service Layer Architecture**: Clean separation of business logic
- **RESTful API**: JSON API for cart and product operations
- **Responsive Design**: Mobile-first design with Tailwind CSS
- **Payment Integration**: Stripe payment gateway support
- **Stock Management**: Automatic inventory tracking
- **Database Relationships**: Properly structured Eloquent models

## 📋 Requirements

- PHP 8.1 or higher
- Composer
- Node.js 18+ and NPM
- MySQL 8.0+ or PostgreSQL
- Laravel 10.x

## 🛠️ Installation

### 1. Clone and Install Dependencies

```bash
# Navigate to project directory
cd "SmartCart – Modern E-Commerce Web Application"

# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 2. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Database Configuration

Edit your `.env` file with database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smartcart
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Run Migrations and Seeders

```bash
# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

This will create:

- 4 main categories with subcategories
- 8 sample products
- 4 promotional coupons

### 5. Storage Setup

```bash
# Create symbolic link for storage
php artisan storage:link
```

### 6. Build Assets

```bash
# Development build with hot reload
npm run dev

# Production build
npm run build
```

### 7. Start Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 📁 Project Structure

```
SmartCart/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── HomeController.php
│   │       ├── ProductController.php
│   │       ├── CheckoutController.php
│   │       ├── OrderController.php
│   │       ├── ReviewController.php
│   │       └── Api/
│   │           ├── CartController.php
│   │           └── ProductController.php
│   ├── Models/
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Review.php
│   │   ├── Coupon.php
│   │   └── Wishlist.php
│   └── Services/
│       ├── CartService.php
│       ├── OrderService.php
│       ├── ProductService.php
│       └── StripePaymentService.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   │   └── app.css (Tailwind CSS)
│   ├── js/
│   │   ├── app.js
│   │   ├── bootstrap.js
│   │   └── components/
│   │       ├── cart.js
│   │       ├── quantitySelector.js
│   │       ├── productModal.js
│   │       ├── search.js
│   │       └── checkout.js
│   └── views/
│       ├── layouts/
│       ├── components/
│       ├── products/
│       ├── checkout/
│       └── orders/
└── routes/
    ├── web.php
    └── api.php
```

## 🎨 Alpine.js Components

### Cart Component (`cart.js`)

Manages shopping cart state and operations:

- Add/remove items
- Update quantities
- Calculate totals
- Cart sidebar

```javascript
// Usage in Blade
<div x-data="cart">
    <button @click="addItem(productId, quantity)">Add to Cart</button>
    <span x-text="itemCount"></span>
</div>
```

### Quantity Selector (`quantitySelector.js`)

Reusable quantity input with increment/decrement:

```javascript
// Usage
<div x-data="quantitySelector(1, 1, 99)">
    <button @click="decrement">-</button>
    <input x-model="quantity">
    <button @click="increment">+</button>
</div>
```

### Product Modal (`productModal.js`)

Quick view modal for products:

```javascript
<div x-data="productModal">
    <button @click="openModal(productId)">Quick View</button>
</div>
```

### Search Component (`search.js`)

Live search with debouncing:

```javascript
<div x-data="search">
    <input x-model="query" placeholder="Search...">
    <div x-show="isOpen">
        <!-- Results -->
    </div>
</div>
```

### Checkout Component (`checkout.js`)

Multi-step checkout process with validation.

## 🔧 Service Layer

### CartService

Handles all cart operations using session storage:

- `getItems()`: Get cart items
- `addItem($productId, $quantity)`: Add product to cart
- `updateQuantity($itemKey, $quantity)`: Update item quantity
- `removeItem($itemKey)`: Remove item
- `clear()`: Clear entire cart

### ProductService

Manages product queries and filtering:

- `getProducts($filters)`: Get paginated products with filters
- `getFeaturedProducts($limit)`: Get featured products
- `search($query, $limit)`: Search products
- `getRelatedProducts($product, $limit)`: Get related products

### OrderService

Handles order processing:

- `createFromCart($data)`: Create order from cart
- `updateStatus($order, $status)`: Update order status
- `cancel($order)`: Cancel order
- `refund($order)`: Process refund

### StripePaymentService

Payment processing integration:

- `createPaymentIntent($order)`: Create Stripe payment intent
- `confirmPayment($paymentIntentId)`: Confirm payment
- `refund($order, $amount)`: Process refund

## 🗄️ Database Models

### Product Model

- **Relationships**: categories (many-to-many), reviews, orderItems, wishlists
- **Scopes**: active, featured, inStock
- **Methods**: isInStock(), isLowStock(), decrementStock(), incrementStock()
- **Accessors**: discount_percentage, average_rating, primary_image

### Order Model

- **Relationships**: user, items, reviews
- **Scopes**: status, pending, paid
- **Methods**: isPaid(), canBeCancelled(), generateOrderNumber()
- **Accessors**: customer_full_name

### Category Model

- **Relationships**: parent, children, products
- **Scopes**: active, root
- **Self-referencing**: Supports nested categories

## 🎯 API Endpoints

### Cart API

```
GET    /api/cart                    - Get cart data
POST   /api/cart/add                - Add item to cart
PATCH  /api/cart/items/{itemKey}    - Update item quantity
DELETE /api/cart/items/{itemKey}    - Remove item
DELETE /api/cart                    - Clear cart
```

### Product API

```
GET    /api/products/{product}      - Get product details
GET    /api/products/search?q=      - Search products
```

## 🔐 Payment Integration

### Stripe Setup

1. Get API keys from [Stripe Dashboard](https://dashboard.stripe.com/apikeys)

2. Add to `.env`:

```env
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
```

3. The payment flow:
   - Create order
   - Generate payment intent
   - Process payment
   - Update order status

## 🎨 Customization

### Tailwind Configuration

Edit `tailwind.config.js` to customize colors, fonts, and styles:

```javascript
theme: {
  extend: {
    colors: {
      primary: {
        // Your brand colors
      }
    }
  }
}
```

### Adding New Components

1. Create Alpine component in `resources/js/components/`
2. Register in `resources/js/app.js`
3. Use in Blade templates with `x-data="componentName"`

## 📝 Key Design Patterns

### Service Layer Pattern

Business logic is separated into service classes, keeping controllers thin:

- Controllers handle HTTP requests/responses
- Services contain business logic
- Models handle data access

### Repository Pattern

Services interact with models to abstract data access.

### Component Pattern

Alpine.js components are modular and reusable across views.

## 🧪 Sample Data

The seeders create:

**Categories:**

- Electronics (Laptops, Smartphones, Tablets, Accessories)
- Fashion (Men's/Women's Clothing, Shoes, Accessories)
- Home & Garden (Furniture, Kitchen, Garden, Decor)
- Sports & Outdoors (Exercise, Camping, Sports Gear)

**Products:**

- MacBook Pro 16" - $2,499
- iPhone 15 Pro - $999
- Samsung Galaxy Tab S9 - $799
- Sony WH-1000XM5 - $399
- Nike Air Max 2024 - $159
- Ergonomic Office Chair - $449
- Smart Coffee Maker - $199
- Yoga Mat Pro - $59

**Coupons:**

- WELCOME10 - 10% off first order
- SAVE20 - 20% off orders over $100
- FLAT50 - $50 off orders over $200
- FREESHIP - Free shipping

## 🚀 Deployment

### Production Checklist

```bash
# 1. Optimize autoloader
composer install --optimize-autoloader --no-dev

# 2. Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Build production assets
npm run build

# 4. Set environment
APP_ENV=production
APP_DEBUG=false
```

### Environment Variables for Production

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Use production database
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_DATABASE=your-db-name

# Set production mail driver
MAIL_MAILER=smtp

# Use production Stripe keys
STRIPE_KEY=pk_live_...
STRIPE_SECRET=sk_live_...
```

## 🐛 Troubleshooting

### Common Issues

**Cart not working:**

- Ensure session driver is configured correctly
- Check that `APP_KEY` is generated
- Clear cache: `php artisan cache:clear`

**Assets not loading:**

- Run `npm install && npm run build`
- Check Vite configuration
- Ensure `@vite` directive is in layout

**Database errors:**

- Verify database credentials in `.env`
- Run migrations: `php artisan migrate:fresh`
- Check database charset (should be utf8mb4)

## 📚 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Stripe Documentation](https://stripe.com/docs)

## 📄 License

This project is open-sourced software licensed under the MIT license.

## 👨‍💻 Support

For issues and questions, please create an issue in the repository.

---

Built with ❤️ using Laravel & Alpine.js
