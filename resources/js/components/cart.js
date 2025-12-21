/**
 * Shopping Cart Alpine.js Component
 * Manages cart state, adding/removing items, and cart operations
 */
export default () => ({
    // State
    items: [],
    isOpen: false,
    isLoading: false,
    
    // Computed
    get itemCount() {
        return this.items.reduce((sum, item) => sum + item.quantity, 0);
    },
    
    get subtotal() {
        return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    },
    
    get tax() {
        return this.subtotal * 0.08; // 8% tax
    },
    
    get total() {
        return this.subtotal + this.tax;
    },
    
    // Lifecycle
    init() {
        console.log('Cart component initialized');
        this.loadCart();
        
        // Listen for cart update events
        window.addEventListener('cart:updated', () => {
            console.log('Cart updated event received');
            this.loadCart();
        });
        
        // Listen for add-to-cart events from product cards
        window.addEventListener('add-to-cart', (event) => {
            console.log('Add to cart event received:', event.detail);
            const { productId, quantity } = event.detail;
            this.addItem(productId, quantity);
        });
    },
    
    // Methods
    async loadCart() {
        try {
            const response = await axios.get('/api/cart');
            this.items = response.data.items || [];
        } catch (error) {
            console.error('Error loading cart:', error);
            this.items = [];
        }
    },
    
    async addItem(productId, quantity = 1) {
        console.log('Adding item to cart:', productId, quantity);
        this.isLoading = true;
        
        try {
            const response = await axios.post('/api/cart/add', {
                product_id: productId,
                quantity: quantity
            });
            
            console.log('Cart add response:', response.data);
            this.items = response.data.items;
            this.isOpen = true; // Open cart sidebar
            console.log('Cart opened, items:', this.items);
            window.showNotification('Item added to cart', 'success');
            
            // Dispatch event
            window.dispatchEvent(new CustomEvent('cart:updated'));
        } catch (error) {
            console.error('Error adding to cart:', error);
            window.showNotification('Failed to add item to cart', 'error');
        } finally {
            this.isLoading = false;
        }
    },
    
    async updateQuantity(itemId, quantity) {
        if (quantity < 1) {
            return this.removeItem(itemId);
        }
        
        this.isLoading = true;
        
        try {
            const response = await axios.patch(`/api/cart/items/${itemId}`, {
                quantity: quantity
            });
            
            this.items = response.data.items;
            window.dispatchEvent(new CustomEvent('cart:updated'));
        } catch (error) {
            console.error('Error updating cart:', error);
            window.showNotification('Failed to update cart', 'error');
        } finally {
            this.isLoading = false;
        }
    },
    
    async removeItem(itemId) {
        this.isLoading = true;
        
        try {
            const response = await axios.delete(`/api/cart/items/${itemId}`);
            this.items = response.data.items;
            window.showNotification('Item removed from cart', 'success');
            window.dispatchEvent(new CustomEvent('cart:updated'));
        } catch (error) {
            console.error('Error removing item:', error);
            window.showNotification('Failed to remove item', 'error');
        } finally {
            this.isLoading = false;
        }
    },
    
    async clearCart() {
        if (!confirm('Are you sure you want to clear your cart?')) {
            return;
        }
        
        this.isLoading = true;
        
        try {
            await axios.delete('/api/cart');
            this.items = [];
            window.showNotification('Cart cleared', 'success');
            window.dispatchEvent(new CustomEvent('cart:updated'));
        } catch (error) {
            console.error('Error clearing cart:', error);
            window.showNotification('Failed to clear cart', 'error');
        } finally {
            this.isLoading = false;
        }
    },
    
    toggleCart() {
        this.isOpen = !this.isOpen;
    },
    
    closeCart() {
        this.isOpen = false;
    },
    
    formatPrice(price) {
        return '$' + parseFloat(price).toFixed(2);
    }
});
