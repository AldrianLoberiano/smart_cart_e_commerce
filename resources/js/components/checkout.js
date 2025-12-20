/**
 * Checkout Component Alpine.js
 * Handles checkout process and payment
 */
export default () => ({
    step: 1,
    isProcessing: false,
    
    // Shipping Information
    shippingInfo: {
        firstName: '',
        lastName: '',
        email: '',
        phone: '',
        address: '',
        city: '',
        state: '',
        zipCode: '',
        country: 'US'
    },
    
    // Payment Information
    paymentMethod: 'card',
    
    // Validation errors
    errors: {},
    
    get canProceedToPayment() {
        return this.validateShippingInfo();
    },
    
    validateShippingInfo() {
        this.errors = {};
        
        const required = ['firstName', 'lastName', 'email', 'address', 'city', 'state', 'zipCode'];
        
        for (const field of required) {
            if (!this.shippingInfo[field]) {
                this.errors[field] = 'This field is required';
            }
        }
        
        // Email validation
        if (this.shippingInfo.email && !this.isValidEmail(this.shippingInfo.email)) {
            this.errors.email = 'Please enter a valid email address';
        }
        
        return Object.keys(this.errors).length === 0;
    },
    
    isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    },
    
    async proceedToPayment() {
        if (!this.validateShippingInfo()) {
            window.showNotification('Please fill in all required fields', 'error');
            return;
        }
        
        this.step = 2;
    },
    
    backToShipping() {
        this.step = 1;
    },
    
    async processPayment() {
        if (this.isProcessing) return;
        
        this.isProcessing = true;
        
        try {
            const response = await axios.post('/api/checkout/process', {
                shipping: this.shippingInfo,
                payment_method: this.paymentMethod
            });
            
            if (response.data.success) {
                window.location.href = `/orders/${response.data.order_id}/confirmation`;
            } else {
                window.showNotification(response.data.message || 'Payment failed', 'error');
            }
        } catch (error) {
            console.error('Payment error:', error);
            window.showNotification('Payment processing failed. Please try again.', 'error');
        } finally {
            this.isProcessing = false;
        }
    },
    
    selectPaymentMethod(method) {
        this.paymentMethod = method;
    }
});
