import './bootstrap';
import Alpine from 'alpinejs';

// Make Alpine available globally
window.Alpine = Alpine;

// Global functions - Define BEFORE Alpine starts
window.formatPrice = (price) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(price);
};

window.showNotification = (message, type = 'success') => {
    // Dispatch custom event for notifications
    window.dispatchEvent(new CustomEvent('notification', {
        detail: { message, type }
    }));
};

// Import Alpine.js components
import cartComponent from './components/cart';
import quantitySelector from './components/quantitySelector';
import productModal from './components/productModal';
import searchComponent from './components/search';
import checkoutComponent from './components/checkout';

// Register Alpine components
Alpine.data('cart', cartComponent);
Alpine.data('quantitySelector', quantitySelector);
Alpine.data('productModal', productModal);
Alpine.data('search', searchComponent);
Alpine.data('checkout', checkoutComponent);

// Start Alpine
Alpine.start();
