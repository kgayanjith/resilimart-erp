<template>
    <AppLayout>
        <main class="checkout-page mt-4">
            <div class="container-fluid px-lg-5 py-4">
                <h3 class="page-title mb-4">Checkout</h3>

                <div class="row g-4">
                    <!-- Left column: forms -->
                    <div class="col-lg-7">
                        <!-- Customer details -->
                        <div class="checkout-card mb-4 border">
                             <div class="d-flex justify-content-between align-items-start mb-4">
                                <h5 class="card-heading mb-0">Customer Details</h5>
                                <Link :href="route('profile.edit')" class="edit-address-link text-black">
                                <i class="fa-solid fa-pen me-1"></i>Change in Profile
                                </Link>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="field-label">Full Name</label>
                                    <input type="text" class="field-input" :value="$page.props.customerAuth.user.name"
                                        placeholder="Full name" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="field-label">Email</label>
                                    <input type="email" class="field-input" :value="$page.props.customerAuth.user.email"
                                        placeholder="Email address" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="field-label">Phone Number</label>
                                    <input type="tel" class="field-input" :value="$page.props.customerAuth.user.phone"
                                        placeholder="Phone number" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- Billing address -->
                        <div class="checkout-card mb-4 border">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-heading mb-0">Billing Address</h5>
                                <Link :href="route('profile.edit')" class="edit-address-link text-black">
                                <i class="fa-solid fa-pen me-1"></i>Change in Profile
                                </Link>
                            </div>

                            <div class="address-display">
                                <p class="address-line">{{ $page.props.customerAuth.user.address }}</p>
                            </div>
                        </div>

                        <!-- Payment method -->
                        <div class="checkout-card mb-4 border">
                            <h5 class="card-heading">Payment Method</h5>
                            <div class="payment-options">
                                <label class="payment-option" :class="{ selected: form.payment === 'cod' }">
                                    <input type="radio" name="payment" value="cod" checked
                                        @change="form.payment = 'cod'">
                                    <i class="fa-solid fa-money-bill-wave"></i>
                                    <span>Cash on Delivery</span>
                                </label>
                                <label class="payment-option" :class="{ selected: form.payment === 'card' }" >
                                    <input type="radio" name="payment" value="card" @change="form.payment = 'card'">
                                    <i class="fa-regular fa-credit-card"></i>
                                    <span>Credit / Debit Card</span>
                                </label>
                                <label class="payment-option" :class="{ selected: form.payment === 'bank_transfer' }">
                                    <input type="radio" name="payment" value="bank_transfer"
                                        @change="form.payment = 'bank_transfer'">
                                    <i class="fa-solid fa-building-columns"></i>
                                    <span>Bank Transfer</span>
                                </label>
                                <p class="bank-note" v-if="form.payment === 'bank_transfer'">
                                    <i class="fa-solid fa-circle-info me-1"></i>
                                    Your order will only be confirmed once we've received and verified your bank
                                    transfer. This may take 1-2 business days.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right column: order summary -->
                    <div class="col-lg-5">
                        <div class="checkout-card summary-card">
                            <h5 class="card-heading">Order Summary</h5>

                            <div class="product-list">
                                <!-- Loop: replace with v-for="item in cartItems" :key="item.id" -->
                                <div class="product-row" v-for="item in cartItems" :key="item.id">
                                    <div class="product-thumb">
                                        <img :src="item.image" :alt="item.name">
                                    </div>
                                    <div class="product-info">
                                        <p class="product-name">{{ item.name }}</p>
                                        <p class="product-meta">Qty: {{ item.quantity }}</p>
                                    </div>
                                    <div class="product-total">Rs {{ item.price }}.00</div>
                                </div>
                            </div>

                            <div class="summary-divider"></div>

                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span>Rs {{ subTotal.toFixed(2) }}</span>
                            </div>
                            <div class="summary-row">
                                <span>Shipping</span>
                                <span>free</span>
                            </div>
                            <div class="summary-row">
                                <span>Discount</span>
                                <span class="text-discount">-</span>
                            </div>
                            <div class="summary-row">
                                <span>VAT(18%)</span>
                                <span class="text-discount">{{ vatAmount.toFixed(2) }}</span>
                            </div>

                            <div class="summary-divider"></div>

                            <div class="summary-row total-row">
                                <span>Total</span>
                                <span>Rs {{ netTotal.toFixed(2) }}</span>
                            </div>

                            <button class="btn-place-order w-100 mt-3" @click="placeOrder"
                                :disabled="!cartItems.length">
                                Place Order
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                    <polyline points="12 5 19 12 12 19" />
                                </svg>
                            </button>

                            <p class="secure-note text-center mt-3">
                                <i class="fa-solid fa-lock me-1"></i>Your information is secure and encrypted.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <button type="button" class="d-none" ref="successTrigger" data-bs-toggle="modal"
            data-bs-target="#orderSuccessModal"></button>
        <button type="button" class="d-none" ref="closeTrigger" data-bs-dismiss="modal"
            data-bs-target="#orderSuccessModal"></button>

        <div class="modal fade" id="orderSuccessModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content success-modal-content">
                    <div class="modal-body text-center py-5 px-4">
                        <div class="check-wrap mx-auto mb-4">
                            <svg viewBox="0 0 52 52" class="check-svg">
                                <circle class="check-circle" cx="26" cy="26" r="24" fill="none" />
                                <path class="check-mark" fill="none" d="M14 27l7 7 16-16" />
                            </svg>
                        </div>

                        <h4 class="success-title mb-2">Order Placed!</h4>
                        <p class="success-sub mb-4">
                            Thank you for your order. We've received it and will start processing it right away.
                        </p>

                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                            <button type="button" @click="continueShopping" class="btn-secondary-action">
                                Continue Shopping
                            </button>
                            <button type="button" @click="ordersView" class="btn-primary-action">
                            View Orders
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { mapState, mapGetters, mapActions } from 'vuex';

export default {
    components: {
        AppLayout,
        Link
    },
    data() {
        return {
            form: useForm({
                payment: 'cod',
                cartItems: []
            })
        };
    },
    computed: {
        ...mapState({
            cartItems: state => state.cartItems,
        }),
        ...mapGetters(['totalItems', 'subTotal']),

        vatAmount() {
            return (this.subTotal * 18) / 100;
        },
        netTotal() {
            return this.subTotal + this.vatAmount;
        },
        orderSucceeded() {
            return this.$page.props.flash?.success === true;
        },
        orderErrorMessage() {
            return this.$page.props.flash?.error ?? 'Something went wrong. Please try again.';
        }
    },
    methods: {
        ...mapActions(['clearCart']),

        placeOrder() {
            if (!this.cartItems.length) return;

            this.form.cartItems = this.cartItems.map(item => ({
                id: item.id,
                quantity: item.quantity
            }));

            this.form.post(this.route('checkout.store'), {
                onSuccess: (page) => {
                    if (page.props.flash?.success) {
                        this.clearCart();
                    }
                    this.show();
                }
            });

        },
        show() {
            this.$refs.successTrigger.click();
        },
        hide() {
            this.$refs.closeTrigger.click();
        },
        continueShopping() {
            this.hide();
            this.clearCart();
            this.$inertia.visit(this.route('home'));
        },
        ordersView(){
            this.hide();
            this.clearCart();
            this.$inertia.visit(this.route('orders.show'));
        }
    }
}
</script>
<style>

</style>
<style scoped>
.checkout-page {
    background: #ffffff;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
}

.page-title {
    font-family: 'Manrope', sans-serif;
    font-weight: 700;
    color: #14332f;
}

.checkout-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 1.75rem;
    box-shadow: 0 8px 24px -10px rgba(5, 19, 18, 0.08);
}

.card-heading {
    font-family: 'Manrope', sans-serif;
    font-weight: 700;
    color: #14332f;
    margin-bottom: 1.25rem;
}

.field-label {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    color: #274b47;
    margin-bottom: 0.35rem;
}

.field-input {
    width: 100%;
    padding: 0.65rem 0.9rem;
    font-size: 0.9rem;
    color: #14332f;
    background: #f6f9f8;
    border: 1.5px solid #e3ebea;
    border-radius: 10px;
    transition: border-color 0.15s ease, background 0.15s ease;
}

.field-input:focus {
    outline: none;
    border-color: #14b8a6;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.12);
}

.checkbox-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: #4b615e;
    cursor: pointer;
}

.checkbox-row input {
    accent-color: #14b8a6;
}

/* Payment options */
.payment-options {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.payment-option {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.85rem 1rem;
    border: 1.5px solid #e3ebea;
    border-radius: 12px;
    cursor: pointer;
    transition: border-color 0.15s ease, background 0.15s ease;
}

.payment-option:hover {
    border-color: #b9d9d5;
}

.payment-option.selected,
.payment-option:has(input:checked) {
    border-color: #000000;
    background: #f0faf8;
}

.payment-option input {
    accent-color: #000000;
}

.payment-option i {
    color: #000000;
    width: 18px;
}

.payment-option span {
    font-size: 0.9rem;
    font-weight: 500;
    color: #14332f;
}

.card-fields {
    padding-top: 0.75rem;
    border-top: 1px dashed #e3ebea;
}

/* Order summary */
.summary-card {
    position: sticky;
    top: 1.5rem;
}

.product-list {
    display: flex;
    flex-direction: column;
    gap: 0.9rem;
    margin-bottom: 1rem;
}

.product-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.product-thumb {
    width: 56px;
    height: 56px;
    border-radius: 10px;
    overflow: hidden;
    background: #f6f9f8;
    flex-shrink: 0;
}

.product-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-info {
    flex: 1;
    min-width: 0;
}

.product-name {
    font-size: 0.87rem;
    font-weight: 600;
    color: #14332f;
    margin-bottom: 0.15rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.product-meta {
    font-size: 0.78rem;
    color: #7c9390;
    margin-bottom: 0;
}

.product-total {
    font-size: 0.87rem;
    font-weight: 600;
    color: #14332f;
    white-space: nowrap;
}

.summary-divider {
    height: 1px;
    background: #e9f0ef;
    margin: 0.9rem 0;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.88rem;
    color: #4b615e;
    margin-bottom: 0.55rem;
}

.text-discount {
    color: #0d9488;
}

.total-row {
    font-family: 'Manrope', sans-serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: #14332f;
    margin-bottom: 0;
}

.btn-place-order {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.85rem;
    font-size: 0.95rem;
    font-weight: 600;
    color: #ffffff;
    background: black;
    border: none;
    border-radius: 10px;
    transition: transform 0.12s ease, box-shadow 0.12s ease;
    box-shadow: 0 8px 20px -6px rgba(13, 148, 136, 0.45);
}

.btn-place-order:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 24px -6px rgba(13, 148, 136, 0.55);
}

.btn-place-order:disabled {
    opacity: 0.5;
    cursor: not-allowed !important;
    pointer-events: none;
}

.secure-note {
    font-size: 0.78rem;
    color: #8fa3a0;
}

.edit-address-link {
    display: inline-flex;
    align-items: center;
    font-size: 0.82rem;
    font-weight: 600;
    color: #0d9488;
    text-decoration: none;
    white-space: nowrap;
}

.edit-address-link:hover {
    color: #0f766e;
    text-decoration: underline;
}

.address-display {
    padding: 1rem 1.1rem;
    background: #f6f9f8;
    border: 1px solid #e6edec;
    border-radius: 12px;
}

.address-line {
    font-size: 0.92rem;
    color: #14332f;
    margin-bottom: 0.25rem;
}

.address-line:last-child {
    margin-bottom: 0;
}

.bank-note {
    display: flex;
    align-items: flex-start;
    gap: 0.3rem;
    font-size: 0.8rem;
    color: #b45309;
    background: #fffbeb;
    border: 1px solid #fde8b8;
    border-radius: 10px;
    padding: 0.65rem 0.85rem;
    margin: -0.35rem 0 0.5rem 0;
    line-height: 1.5;
}

.bank-note i {
    margin-top: 0.15rem;
    color: #b45309;
    flex-shrink: 0;
}

@media (max-width: 991.98px) {
    .summary-card {
        position: static;
    }
}
</style>
<style scoped>
.success-modal-content {
    border: none;
    border-radius: 20px;
    box-shadow: 0 24px 60px -12px rgba(5, 19, 18, 0.35);
}

.check-wrap {
    width: 76px;
    height: 76px;
}

.check-svg {
    width: 100%;
    height: 100%;
}

.check-circle {
    stroke: #000000;
    stroke-width: 2.5;
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    animation: circle-draw 0.5s ease-out forwards;
}

.check-mark {
    stroke: #000000;
    stroke-width: 3.5;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: check-draw 0.35s 0.45s ease-out forwards;
}

@keyframes circle-draw {
    to {
        stroke-dashoffset: 0;
    }
}

@keyframes check-draw {
    to {
        stroke-dashoffset: 0;
    }
}

.success-title {
    font-family: 'Manrope', sans-serif;
    font-weight: 700;
    color: #14332f;
}

.success-sub {
    font-size: 0.9rem;
    color: #6b7c7a;
    line-height: 1.6;
    max-width: 320px;
    margin-left: auto;
    margin-right: auto;
}

.btn-primary-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.65rem 1.4rem;
    font-size: 0.88rem;
    font-weight: 600;
    color: #ffffff;
    background: black;
    border: none;
    border-radius: 10px;
    text-decoration: none;
    transition: transform 0.12s ease, box-shadow 0.12s ease;
    box-shadow: 0 8px 20px -6px rgba(13, 148, 136, 0.4);
}

.btn-primary-action:hover {
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 10px 24px -6px rgba(13, 148, 136, 0.5);
}

.btn-secondary-action {
    padding: 0.65rem 1.4rem;
    font-size: 0.88rem;
    font-weight: 600;
    color: #274b47;
    background: #f6f9f8;
    border: 1.5px solid #e3ebea;
    border-radius: 10px;
    transition: border-color 0.15s ease, background 0.15s ease;
}

.btn-secondary-action:hover {
    border-color: #b9d9d5;
    background: #eef5f4;
}


</style>