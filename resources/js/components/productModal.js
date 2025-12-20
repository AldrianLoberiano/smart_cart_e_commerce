/**
 * Product Modal Alpine.js Component
 * Quick view modal for products
 */
export default () => ({
    isOpen: false,
    product: null,
    isLoading: false,
    selectedVariant: null,
    quantity: 1,
    
    async openModal(productId) {
        this.isLoading = true;
        this.isOpen = true;
        
        try {
            const response = await axios.get(`/api/products/${productId}`);
            this.product = response.data;
            this.selectedVariant = this.product.variants?.[0] || null;
            this.quantity = 1;
        } catch (error) {
            console.error('Error loading product:', error);
            window.showNotification('Failed to load product', 'error');
            this.closeModal();
        } finally {
            this.isLoading = false;
        }
    },
    
    closeModal() {
        this.isOpen = false;
        setTimeout(() => {
            this.product = null;
            this.selectedVariant = null;
            this.quantity = 1;
        }, 300); // Wait for animation
    },
    
    selectVariant(variant) {
        this.selectedVariant = variant;
    },
    
    get currentPrice() {
        return this.selectedVariant?.price || this.product?.price || 0;
    },
    
    get isInStock() {
        if (this.selectedVariant) {
            return this.selectedVariant.stock > 0;
        }
        return this.product?.stock > 0;
    },
    
    async addToCart() {
        if (!this.isInStock) {
            window.showNotification('Product is out of stock', 'error');
            return;
        }
        
        const productId = this.selectedVariant?.id || this.product.id;
        
        // Use the global cart component
        window.dispatchEvent(new CustomEvent('add-to-cart', {
            detail: {
                productId: productId,
                quantity: this.quantity
            }
        }));
        
        this.closeModal();
    }
});
