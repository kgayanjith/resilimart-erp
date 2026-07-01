<template>
    <AppLayout>
        <div class="cart-root">
            <div class="cart-container container-fluid px-4 px-lg-5">
                <div class="row g-0">

                    <div class="items-header mt-5">
                       <h3 class="">Your Cart</h3>
                        <span class="item-count">{{ totalItems }} items</span>
                    </div>
                    <div class="col-lg-6 col-xl-7 p-4 custom-bg-setting rounded rounded-3 border-0">

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
                                <div v-else v-for="item in cartItems" :key="item.id"
                                    class="cart-item border-0 bg-white px-3 rounded mb-2 shadow-sm">

                                    <div class="item-image-wrap">
                                        <img :src="item.image" :alt="item.name" class="item-image" />
                                    </div>


                                    <div class="item-details">
                                        <div class="item-top">
                                            <div class="mb-2">
                                                <p class="item-category item-decription">{{ item.category }}</p>
                                                <h3 class="item-name">{{ item.name }}</h3>
                                                <p class="item-category w-50 two-line-clamp">{{ item.description }}</p>
                                            </div>
                                            <button @click="removeItem(item.id)" class="btn btn-sm" style="width:28px; height:28px; border:1px solid #fca5a5;
               border-radius:6px; color:#ef4444; background:transparent;
               display:flex; align-items:center; justify-content:center; cursor:pointer;">
                                                ✕
                                            </button>
                                        </div>

                                        <div class="item-bottom">
                                            <div class="qty-control">
                                                <button class="qty-btn" @click="decrease(item.id)"
                                                    :disabled="item.quantity <= 1">−</button>
                                                <span class="qty-value">{{ item.quantity }}</span>
                                                <button class="qty-btn" @click="increase(item.id)">+</button>
                                            </div>

                                            <div class="item-price-wrap">
                                                <span class="item-price fs-6">Rs {{ (item.price *
                                                    item.quantity).toFixed(2)
                                                    }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </transition-group>
                        </div>
                    </div>

                    <div class="col-lg-6 col-xl-5  p-3">
                        <div class="summary-card">
                            <h2 class="summary-title">Order Summary</h2>

                            <div class="summary-lines">
                                <div class="summary-line">
                                    <span>Subtotal</span>
                                    <span>{{ subTotal.toFixed(2) }}</span>
                                </div>
                                <div class="summary-line">
                                    <span>Shipping</span>
                                    <span class="free-label">Free</span>
                                </div>
                                <div class="summary-line">
                                    <span>VAT (18%)</span>
                                    <span>{{ vatAmount.toFixed(2) }}</span>
                                </div>
                            </div>

                            <div class="summary-divider"></div>

                            <div class="summary-total">
                                <span>Total</span>
                                <span class="total-val fs-5">Rs {{ netTotal.toFixed(2) }}</span>
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
            <transition name="toast-slide">
                <div v-if="toast" class="toast-msg">{{ toastMsg }}</div>
            </transition>

        </div>
    </AppLayout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { mapState, mapGetters, mapActions } from 'vuex';

export default {
    components: {
        AppLayout,
        Link
    },
    computed: {
        ...mapState({
            cartItems: state => state.cartItems,
            toast: state => state.toast,
            toastMsg: state => state.toastMsg
        }),
        ...mapGetters(['totalItems', 'subTotal']),

        vatAmount() {
            return (this.subTotal * 18) / 100;
        },
        netTotal() {
            return this.subTotal + this.vatAmount;
        }
    },
    methods: {
        ...mapActions(['removeItem']),

        increase(id) {
            this.$store.dispatch('increaseItem', id);
        },

        decrease(id) {
            this.$store.dispatch('decreaseItem', id);
        },

        goCheckout() {
            this.$inertia.visit(this.route('checkout'));
        }
    },
}
</script>

<style></style>