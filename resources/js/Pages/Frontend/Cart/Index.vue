<template>
    <div class="cart-root">

        <div class="cart-container container-fluid px-4 px-lg-5">
            <div class="row g-0">

                <!-- LEFT: Items -->
                <div class="col-lg-6 col-xl-7 items-col">
                    <div class="items-header">
                        <h1 class="cart-title">Your Cart</h1>
                        <span class="item-count">{{ cartItems.length }} items</span>
                    </div>

                    <div class="items-list">
                        <transition-group name="slide-fade">
                            <div class="" v-if="cartItems.length == 0">
                                <div class="mb-3">Looks like your cart is empty. Start shopping to fill it up!
                                </div>
                                <div class="buy-bar">
                                    <Link class="buy-link" :href="route('home')">Continue Shopping
                                    </Link>
                                </div>

                            </div>
                            <div v-else v-for="item in cartItems" :key="item.id" class="cart-item">
                                <!-- Product image -->
                                <div class="item-image-wrap">
                                    <img :src="item.image" :alt="item.name" class="item-image" />
                                </div>

                                <!-- Details -->
                                <div class="item-details">
                                    <div class="item-top">
                                        <div>
                                            <p class="item-category text-black">{{ item.category }}</p>
                                            <h3 class="item-name">{{ item.name }}</h3>
                                        </div>
                                        <button class="remove-btn" @click="removeItem(item.id)" title="Remove">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <line x1="18" y1="6" x2="6" y2="18" />
                                                <line x1="6" y1="6" x2="18" y2="18" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="item-bottom">
                                        <!-- Qty control -->
                                        <div class="qty-control">
                                            <button class="qty-btn" @click="decrease(item.id)"
                                                :disabled="item.quantity <= 1">−</button>
                                            <span class="qty-value">{{ item.quantity }}</span>
                                            <button class="qty-btn" @click="increase(item.id)">+</button>
                                        </div>

                                        <div class="item-price-wrap">
                                            <span class="item-price">Rs {{ (item.price * item.qty).toFixed(2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </transition-group>
                    </div>
                </div>

                <!-- RIGHT: Summary -->
                <div class="col-lg-6 col-xl-5 summary-col">
                    <div class="summary-card">
                        <h2 class="summary-title">Order Summary</h2>

                        <div class="summary-lines">
                            <div class="summary-line">
                                <span>Subtotal</span>
                                <span>$sda</span>
                            </div>
                            <div class="summary-line" v-if="promoValid">
                                <span class="discount-label">Promo </span>
                                <span class="discount-val">-$dsd</span>
                            </div>
                            <div class="summary-line">
                                <span>Shipping</span>
                                <span class="free-label">Free</span>
                            </div>
                            <div class="summary-line">
                                <span>Tax (8%)</span>
                                <span>$dsd</span>
                            </div>
                        </div>

                        <div class="summary-divider"></div>

                        <div class="summary-total">
                            <span>Total</span>
                            <span class="total-val">$dsd</span>
                        </div>
                        <div class="pay-methods">
                            <span class="pay-label">We accept</span>
                            <div class="pay-icons">
                                <span class="pay-icon">VISA</span>
                                <span class="pay-icon">MC</span>
                                <span class="pay-icon">AMEX</span>
                                <span class="pay-icon">PayPal</span>
                            </div>
                        </div>

                        <button class="btn-checkout" @click="goCheckout">
                            Proceed to Checkout
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <line x1="5" y1="12" x2="19" y2="12" />
                                <polyline points="12 5 19 12 12 19" />
                            </svg>
                        </button>

                        <p class="secure-note">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            Secure 256-bit SSL checkout
                        </p>
                    </div>
                </div>

            </div>
        </div>
        <!-- Toast -->
        <transition name="toast-slide">
            <div v-if="toast" class="toast-msg">{{ toast_msg }}</div>
        </transition>

    </div>

</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
Link

export default {
    layout: AppLayout,

    inject: ['appLayout'],
    components: {
        Link
    },
    data() {
        return {
            toast: false,
            toast_msg: '',
            cartItems: JSON.parse(sessionStorage.getItem('cart')) || [],

        }
    },
    computed: {
   
  
    },
    mounted() {

    },
    methods: {
        increase(id) {
            const item = this.cartItems.find(item => item.id === id);

            if (item) {
                item.quantity++;
                sessionStorage.setItem('cart', JSON.stringify(this.cartItems));
            }
        },

        decrease(id) {
            const item = this.cartItems.find(item => item.id === id);

            if (item) {
                if (item.quantity > 1) {
                    item.quantity--;
                } else {
                    this.removeItem(id);
                    return;
                }

                sessionStorage.setItem('cart', JSON.stringify(this.cartItems));
            }
        },

        removeItem(id) {
            this.cartItems = this.cartItems.filter(item => item.id !== id);

            sessionStorage.setItem('cart', JSON.stringify(this.cartItems));
            totalItems(() =>{
                return this.cartItems.length;
            })
            this.toast_msg = 'Item removed from the cart'
            this.toast = true;
            setTimeout(() => {
                this.toast = false;
                this.toast_msg = ''
            }, 2000);
        },
    },
}
</script>

<style></style>