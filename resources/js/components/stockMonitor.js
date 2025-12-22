export default () => ({
    products: {},
    init() {
        // Start real-time stock monitoring
        this.startStockMonitoring();
        
        // Initialize products on page
        this.initializeProducts();
    },

    initializeProducts() {
        // Find all product elements on the page
        const productElements = document.querySelectorAll('[data-product-id]');
        productElements.forEach(el => {
            const productId = el.getAttribute('data-product-id');
            const stock = parseInt(el.getAttribute('data-product-stock') || '0');
            this.products[productId] = stock;
        });
    },

    startStockMonitoring() {
        // Poll for stock updates every 3 seconds
        setInterval(() => {
            this.checkStockUpdates();
        }, 3000);

        // Also listen for custom stock update events (for immediate updates after cart actions)
        window.addEventListener('stock-updated', (event) => {
            this.updateProductStock(event.detail.productId, event.detail.stock);
        });
    },

    async checkStockUpdates() {
        const productIds = Object.keys(this.products);
        if (productIds.length === 0) return;

        try {
            const response = await axios.post('/api/stock/check', {
                product_ids: productIds
            });

            if (response.data.success) {
                response.data.stocks.forEach(item => {
                    this.updateProductStock(item.product_id, item.stock);
                });
            }
        } catch (error) {
            console.error('Error checking stock updates:', error);
        }
    },

    updateProductStock(productId, newStock) {
        const oldStock = this.products[productId];
        
        if (oldStock !== undefined && oldStock !== newStock) {
            this.products[productId] = newStock;
            
            // Update all elements showing this product's stock
            const stockElements = document.querySelectorAll(`[data-stock-display="${productId}"]`);
            stockElements.forEach(el => {
                el.textContent = newStock;
                
                // Update stock status classes
                const container = el.closest('[data-product-id]');
                if (container) {
                    this.updateStockStatus(container, newStock);
                }
            });

            // Show notification if stock decreased significantly
            if (oldStock > newStock && (oldStock - newStock) >= 5) {
                window.showNotification(`Stock updated: Only ${newStock} left!`, 'info');
            }
        }
    },

    updateStockStatus(container, stock) {
        const stockBadge = container.querySelector('.stock-badge');
        const addToCartBtn = container.querySelector('.add-to-cart-btn');
        
        if (stock === 0) {
            if (stockBadge) {
                stockBadge.className = 'stock-badge px-2 py-1 rounded text-xs font-semibold bg-red-100 text-red-800';
                stockBadge.textContent = 'Out of Stock';
            }
            if (addToCartBtn) {
                addToCartBtn.disabled = true;
                addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        } else if (stock <= 5) {
            if (stockBadge) {
                stockBadge.className = 'stock-badge px-2 py-1 rounded text-xs font-semibold bg-orange-100 text-orange-800';
                stockBadge.textContent = `Only ${stock} left`;
            }
            if (addToCartBtn) {
                addToCartBtn.disabled = false;
                addToCartBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        } else {
            if (stockBadge) {
                stockBadge.className = 'stock-badge px-2 py-1 rounded text-xs font-semibold bg-green-100 text-green-800';
                stockBadge.textContent = 'In Stock';
            }
            if (addToCartBtn) {
                addToCartBtn.disabled = false;
                addToCartBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
    }
});
