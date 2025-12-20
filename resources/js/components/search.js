/**
 * Search Component Alpine.js
 * Live search functionality with debouncing
 */
export default () => ({
    query: '',
    results: [],
    isLoading: false,
    isOpen: false,
    debounceTimer: null,
    
    init() {
        this.$watch('query', (value) => {
            if (value.length >= 2) {
                this.debouncedSearch();
            } else {
                this.results = [];
                this.isOpen = false;
            }
        });
    },
    
    debouncedSearch() {
        clearTimeout(this.debounceTimer);
        this.debounceTimer = setTimeout(() => {
            this.search();
        }, 300);
    },
    
    async search() {
        if (this.query.length < 2) return;
        
        this.isLoading = true;
        
        try {
            const response = await axios.get('/api/products/search', {
                params: { q: this.query }
            });
            
            this.results = response.data.products || [];
            this.isOpen = true;
        } catch (error) {
            console.error('Search error:', error);
            this.results = [];
        } finally {
            this.isLoading = false;
        }
    },
    
    clearSearch() {
        this.query = '';
        this.results = [];
        this.isOpen = false;
    },
    
    selectProduct(productId) {
        window.location.href = `/products/${productId}`;
    }
});
