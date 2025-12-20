# SmartCart - Architecture & Code Explanation

## 📐 Architecture Overview

SmartCart follows a **clean architecture** approach with clear separation of concerns:

```
┌─────────────────────────────────────────────────────┐
│                   Presentation Layer                 │
│  (Blade Templates + Alpine.js Components)            │
└─────────────────┬───────────────────────────────────┘
                  │
┌─────────────────▼───────────────────────────────────┐
│                 Controller Layer                     │
│  (HTTP Request/Response Handling)                    │
└─────────────────┬───────────────────────────────────┘
                  │
┌─────────────────▼───────────────────────────────────┐
│                  Service Layer                       │
│  (Business Logic & Operations)                       │
└─────────────────┬───────────────────────────────────┘
                  │
┌─────────────────▼───────────────────────────────────┐
│                   Model Layer                        │
│  (Data Access & Eloquent ORM)                        │
└─────────────────┬───────────────────────────────────┘
                  │
┌─────────────────▼───────────────────────────────────┐
│                    Database                          │
└─────────────────────────────────────────────────────┘
```

## 🎯 Key Design Principles

### 1. Single Responsibility Principle

Each class has one job:

- **Controllers**: Handle HTTP requests
- **Services**: Contain business logic
- **Models**: Manage data relationships
- **Components**: Handle UI interactions

### 2. Dependency Injection

Services are injected into controllers:

```php
public function __construct(
    private CartService $cartService,
    private ProductService $productService
) {}
```

### 3. Eloquent Relationships

Models define clear relationships:

```php
// Product.php
public function categories(): BelongsToMany
{
    return $this->belongsToMany(Category::class);
}

public function reviews(): HasMany
{
    return $this->hasMany(Review::class);
}
```

## 🔍 Code Walkthrough

### Cart System Flow

**1. User adds product to cart (Frontend)**

```html
<!-- Blade Template -->
<button @click="addItem({{ $product->id }}, 1)">Add to Cart</button>
```

**2. Alpine.js handles the click**

```javascript
// resources/js/components/cart.js
async addItem(productId, quantity = 1) {
    const response = await axios.post('/api/cart/add', {
        product_id: productId,
        quantity: quantity
    });

    this.items = response.data.items;
    window.showNotification('Item added to cart', 'success');
}
```

**3. API Controller receives request**

```php
// app/Http/Controllers/Api/CartController.php
public function store(Request $request): JsonResponse
{
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1|max:99',
    ]);

    $cart = $this->cartService->addItem(
        $validated['product_id'],
        $validated['quantity']
    );

    return response()->json($cart);
}
```

**4. Service handles business logic**

```php
// app/Services/CartService.php
public function addItem(int $productId, int $quantity = 1): array
{
    $product = Product::findOrFail($productId);

    // Check stock
    if (!$product->isInStock()) {
        throw new \Exception('Product is out of stock');
    }

    // Get cart from session
    $cart = Session::get('shopping_cart', []);

    // Add or update item
    if (isset($cart["product_{$productId}"])) {
        $cart["product_{$productId}"]['quantity'] += $quantity;
    } else {
        $cart["product_{$productId}"] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $quantity,
        ];
    }

    // Save to session
    Session::put('shopping_cart', $cart);

    return $this->getCartData();
}
```

### Checkout Process Flow

**1. User navigates to checkout**

```php
// CheckoutController.php
public function index()
{
    $cart = $this->cartService->getCartData();

    if (empty($cart['items'])) {
        return redirect()->route('home')
            ->with('error', 'Your cart is empty');
    }

    return view('checkout.index', ['cart' => $cart]);
}
```

**2. Multi-step form with Alpine.js**

```javascript
// resources/js/components/checkout.js
export default () => ({
  step: 1,
  shippingInfo: {
    /* ... */
  },
  paymentMethod: "card",

  async proceedToPayment() {
    if (!this.validateShippingInfo()) {
      return;
    }
    this.step = 2;
  },

  async processPayment() {
    const response = await axios.post("/api/checkout/process", {
      shipping: this.shippingInfo,
      payment_method: this.paymentMethod,
    });

    window.location.href = `/orders/${response.data.order_id}/confirmation`;
  },
});
```

**3. Order creation with transaction**

```php
// app/Services/OrderService.php
public function createFromCart(array $data): Order
{
    return DB::transaction(function () use ($data) {
        $cartData = $this->cartService->getCartData();

        // Calculate totals
        $total = $cartData['subtotal'] + $cartData['tax'];

        // Create order
        $order = Order::create([
            'customer_email' => $data['email'],
            'customer_first_name' => $data['first_name'],
            // ... other fields
            'total' => $total,
        ]);

        // Create order items and update stock
        foreach ($cartData['items'] as $item) {
            $product = Product::find($item['id']);

            // Decrement stock
            $product->decrementStock($item['quantity']);

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        // Clear cart
        $this->cartService->clear();

        return $order;
    });
}
```

## 🧩 Component Deep Dive

### Quantity Selector Component

**Alpine.js Component**

```javascript
// resources/js/components/quantitySelector.js
export default (initialQuantity = 1, min = 1, max = 99) => ({
  quantity: initialQuantity,
  min: min,
  max: max,

  increment() {
    if (this.quantity < this.max) {
      this.quantity++;
      this.onChange();
    }
  },

  decrement() {
    if (this.quantity > this.min) {
      this.quantity--;
      this.onChange();
    }
  },

  onChange() {
    this.$dispatch("quantity-changed", {
      quantity: this.quantity,
    });
  },
});
```

**Usage in Blade**

```html
<div x-data="quantitySelector(1, 1, {{ $product->stock }})">
  <button @click="decrement">-</button>
  <input x-model="quantity" type="number" />
  <button @click="increment">+</button>
</div>
```

**Why this pattern?**

- ✅ Reusable across the application
- ✅ Configurable min/max values
- ✅ Emits events for parent components
- ✅ Self-contained validation

### Product Modal Component

**Key Features:**

- Lazy loading (only loads product data when opened)
- Smooth transitions
- Integrates with cart system

```javascript
async openModal(productId) {
    this.isLoading = true;
    this.isOpen = true;

    const response = await axios.get(`/api/products/${productId}`);
    this.product = response.data;
    this.isLoading = false;
}
```

## 🗄️ Database Design Decisions

### Why Pivot Tables?

```php
// Many-to-many: Products ↔ Categories
Schema::create('category_product', function (Blueprint $table) {
    $table->foreignId('category_id')->constrained()->onDelete('cascade');
    $table->foreignId('product_id')->constrained()->onDelete('cascade');
    $table->primary(['category_id', 'product_id']);
});
```

**Benefits:**

- Products can belong to multiple categories
- Easy to query: `$product->categories`
- Cascade deletes prevent orphaned records

### Order Structure

```
orders
├── id
├── order_number (unique)
├── user_id (nullable for guest checkout)
├── customer_* (denormalized for data integrity)
├── shipping_* (address fields)
├── subtotal, tax, total
└── status, payment_status

order_items
├── id
├── order_id
├── product_id
├── product_name (snapshot)
├── product_sku (snapshot)
├── price (snapshot)
└── quantity
```

**Why snapshot product data?**

- Historical accuracy: If product price changes, old orders remain correct
- Product deletion: Order history preserved
- Reporting: Accurate financial records

## 🔄 Request Lifecycle Example

**Complete flow: "Add to Cart" button click**

```
1. User clicks button
   └─> Alpine.js `@click="addItem(123, 1)"`

2. Alpine component method
   └─> cart.js: addItem()
       └─> axios.post('/api/cart/add', data)

3. Laravel routing
   └─> routes/api.php
       └─> CartController@store

4. Controller validation
   └─> $request->validate([...])

5. Service call
   └─> $this->cartService->addItem()

6. Business logic
   ├─> Check product exists
   ├─> Verify stock
   ├─> Update session
   └─> Calculate totals

7. Response
   └─> JSON with cart data

8. Alpine updates UI
   ├─> this.items = response.data.items
   ├─> Cart badge updates
   └─> Notification shown
```

## 🎨 Frontend Architecture

### Alpine.js Data Flow

```javascript
// Global cart state
<body x-data="cart">
    <!-- Cart badge (reactive) -->
    <span x-text="itemCount"></span>

    <!-- Product card (can access cart methods) -->
    <button @click="addItem(productId, 1)">
        Add to Cart
    </button>

    <!-- Cart sidebar (shares same state) -->
    <div x-show="isOpen">
        <template x-for="item in items">
            <!-- Cart items -->
        </template>
    </div>
</body>
```

### Component Communication

**Events:**

```javascript
// Dispatch event
window.dispatchEvent(new CustomEvent("cart:updated"));

// Listen for event
window.addEventListener("cart:updated", () => {
  this.loadCart();
});
```

## 💡 Best Practices Used

### 1. Route Model Binding

```php
// Automatic model resolution
public function show(Product $product)
{
    // $product is automatically loaded by slug
}
```

### 2. Query Scopes

```php
// Reusable query logic
Product::active()->featured()->inStock()->get();
```

### 3. Accessors

```php
// Computed properties
public function getDiscountPercentageAttribute(): ?float
{
    if (!$this->compare_price) return null;
    return round((($this->compare_price - $this->price) /
                  $this->compare_price) * 100);
}
```

### 4. Form Validation

```php
$validated = $request->validate([
    'email' => 'required|email',
    'first_name' => 'required|string|max:255',
]);
```

### 5. Database Transactions

```php
DB::transaction(function () {
    // All or nothing
    $order = Order::create([...]);
    OrderItem::create([...]);
    $product->decrementStock();
});
```

## 🔐 Security Features

- **CSRF Protection**: All forms include `@csrf` token
- **SQL Injection**: Eloquent ORM prevents SQL injection
- **XSS Protection**: Blade's `{{ }}` escapes output
- **Validation**: All inputs validated before processing
- **Authorization**: Order access checked: `$order->user_id === auth()->id()`

## 🚀 Performance Optimizations

- **Eager Loading**: `$product->load('categories', 'reviews')`
- **Database Indexes**: On frequently queried columns
- **Query Optimization**: Scopes prevent N+1 queries
- **Session Storage**: Cart uses session (faster than DB)
- **Asset Bundling**: Vite for optimized JS/CSS

---

This architecture ensures **maintainability**, **scalability**, and **testability** while following modern Laravel and JavaScript best practices.
