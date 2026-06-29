
export default {
    getCart() {
        return JSON.parse(sessionStorage.getItem('cart')) || [];
    },

    saveCart(cart) {
        sessionStorage.setItem('cart', JSON.stringify(cart));
    },

    addToCart(product) {
        let cart = this.getCart();

        const existing = cart.find(item => item.id === product.id);

        if (existing) {
            existing.quantity++;
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.media[0]?.original_url,
                quantity: 1
            });
        }

        this.saveCart(cart);

        window.dispatchEvent(new Event('cartUpdated'));
    },

    increaseQuantity(id) {
        let cart = this.getCart();

        const item = cart.find(item => item.id === id);

        if (item) {
            item.quantity++;
        }

        this.saveCart(cart);
        window.dispatchEvent(new Event('cartUpdated'));
    },

    decreaseQuantity(id) {
        let cart = this.getCart();

        const item = cart.find(item => item.id === id);

        if (item && item.quantity > 1) {
            item.quantity--;
        }

        this.saveCart(cart);
        window.dispatchEvent(new Event('cartUpdated'));
    }
}