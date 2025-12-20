/**
 * Quantity Selector Alpine.js Component
 * Reusable component for incrementing/decrementing quantities
 */
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
    
    updateQuantity(value) {
        const newQuantity = parseInt(value);
        
        if (isNaN(newQuantity)) {
            this.quantity = this.min;
        } else if (newQuantity < this.min) {
            this.quantity = this.min;
        } else if (newQuantity > this.max) {
            this.quantity = this.max;
        } else {
            this.quantity = newQuantity;
        }
        
        this.onChange();
    },
    
    onChange() {
        // Dispatch event with new quantity
        this.$dispatch('quantity-changed', { quantity: this.quantity });
    }
});
