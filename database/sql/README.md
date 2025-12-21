# SmartCart Database Documentation

## Overview

This directory contains SQL files for database schema, queries, and management.

## Database Files

### Schema

- **`schema.sql`** - Complete database schema with all tables, indexes, and relationships
  - Users, Products, Categories, Orders, Reviews, Coupons, Wishlists
  - All foreign key relationships and indexes

### Query Files

- **`queries_products.sql`** - Product management queries

  - Basic product queries
  - Inventory management
  - Pricing and discounts
  - Category associations
  - Search and filtering
  - Product statistics

- **`queries_orders.sql`** - Order management queries

  - Order listing and details
  - Customer order history
  - Revenue analysis
  - Product sales tracking
  - Shipping reports
  - Order analytics

- **`queries_analytics.sql`** - Business intelligence queries
  - Dashboard summaries
  - Sales trends and forecasts
  - Customer lifetime value
  - Product performance
  - Conversion metrics
  - Inventory insights

## Usage

### Import Schema

```bash
# PostgreSQL
psql -U postgres -d smartcart -f database/sql/schema.sql

# MySQL
mysql -u root -p smartcart < database/sql/schema.sql

# Laravel Migration (Recommended)
php artisan migrate
```

### Run Queries

You can run these queries directly in your database client or via Laravel:

```bash
# Using psql
psql -U postgres -d smartcart -f database/sql/queries_products.sql

# Using mysql
mysql -u root -p smartcart < database/sql/queries_products.sql

# Or copy individual queries and run them in your DB client
```

### Database Backup

Use the backup script in the root directory:

```bash
.\backup_database.ps1
```

## Database Structure

### Core Tables

#### Users

- Customer accounts and authentication
- Related to: orders, reviews, wishlists

#### Products

- Product catalog with pricing and inventory
- Related to: categories, orders, reviews

#### Categories

- Hierarchical product categorization
- Self-referencing with parent_id

#### Orders

- Customer orders with shipping and payment info
- Related to: users, order_items

#### Order Items

- Individual products in orders
- Links orders to products

#### Reviews

- Product reviews and ratings
- Related to: products, users

#### Coupons

- Discount codes and promotions

#### Wishlists

- Customer saved products
- Related to: users, products

## Query Categories

### Product Queries

- Inventory management (low stock, out of stock)
- Pricing analysis
- Category filtering
- Search functionality
- Product statistics

### Order Queries

- Order tracking and status
- Customer purchase history
- Revenue reporting
- Best sellers
- Geographic analysis

### Analytics Queries

- KPIs and dashboard metrics
- Sales trends (daily, weekly, monthly)
- Customer segmentation
- Product performance
- Inventory turnover

## Best Practices

1. **Always use WHERE clauses** to filter inactive products
2. **Index frequently queried columns** (already done in schema)
3. **Use LIMIT** when testing queries to avoid large result sets
4. **Check execution plans** for slow queries
5. **Backup before making structural changes**

## Performance Tips

- Indexes are created on all foreign keys
- Common filter columns (is_active, status) are indexed
- Use aggregate queries for reports instead of application-level calculations
- Consider materialized views for complex analytics

## Maintenance

### Regular Tasks

- Check slow query log
- Analyze table statistics
- Vacuum/optimize tables (PostgreSQL/MySQL specific)
- Monitor index usage
- Review and archive old orders

### Backup Schedule

- Daily: Automated backups via `backup_database.ps1`
- Weekly: Full database export
- Monthly: Test backup restoration

## Laravel Integration

These SQL files are complementary to Laravel's migration system:

```php
// You can still use Laravel Eloquent
Product::where('is_active', true)
    ->with('categories')
    ->latest()
    ->get();

// Or raw queries when needed
DB::select(file_get_contents(database_path('sql/queries_products.sql')));
```

## Contributing

When adding new queries:

1. Place them in the appropriate query file
2. Add comments explaining the query purpose
3. Include example parameter values
4. Test with realistic data volumes

## Support

For database-specific issues:

- Check Laravel logs: `storage/logs/laravel.log`
- Enable query logging in development
- Review database connection settings in `.env`
