<template>
    <AppLayout>
        <main class="container-fluid px-lg-5 mt-5" style="">
            <div class="row justify-content-center mb-5">
                <div class="col-md-5">
                   <div class="payment-card">
                        <div class="payment-header">
                            <div class="lock-badge">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <h5 class="mb-1">Complete your payment</h5>
                            <p class="text-muted mb-0">Enter your card details to finish this order</p>
                        </div>

                        <div class="amount-box">
                            <span class="amount-label">Amount due</span>
                            <span class="amount-value">LKR {{ order.total }}</span>
                        </div>

                        <form @submit.prevent="handleSubmit">
                            <label class="field-label">Card details</label>
                            <div id="payment-element" ref="paymentElementRef" class="stripe-field mb-3 border-0"></div>
                            <div class="d-flex align-items-center gap-2 mt-2">
                                <button type="button" @click="goBack()" class="btn btn-outline-secondary w-100">
                                    Pay Later
                                </button>
                                <button type="submit" class="btn btn-outline-secondary bg-black text-white w-100" :disabled="loading || !ready">
                                    {{ loading ? 'Processing...' : `Pay LKR ${order.total}` }}
                                </button>
                            </div>

                            <p v-if="message" class="text-danger mt-3 mb-0 text-center">{{ message }}</p>
                        </form>

                        <div class="secure-note">
                            <i class="bi bi-lock-fill"></i>
                            <span>Payments are securely processed by Stripe</span>
                        </div>
                    </div>
            
                </div>
            </div>
            <button type="button" class="d-none" ref="successTriggermodal" data-bs-toggle="modal"
                data-bs-target="#orderSuccessModal"></button>
            <button type="button" class="d-none" ref="closeTriggermodal" data-bs-dismiss="modal"
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
                                Your order has been placed successfully. To confirm it, please complete your payment now
                                or anytime from the Orders page.
                            </p>

                            <div class="d-flex gap-2 justify-content-center flex-wrap">
                                <button @click="gotoOrders()" class="btn btn-primary">
                                    View Orders
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { loadStripe } from '@stripe/stripe-js';
import { mapState, mapGetters, mapActions } from 'vuex';

export default {
    components: {
        AppLayout,
        Link
    },
    props: {
        clientSecret: String,
        stripeKey: String,
        order:Object
    },
    data() {
        return {
            stripe: null,
            elements: null,
            loading: false,
            ready: false,
            message: '',
       
        };
    },
    computed: {
        ...mapState({
            cartItems: state => state.cartItems,
        }),
        ...mapGetters(['totalItems', 'subTotal']),

    },
    async mounted() {
        this.clearCart();
        this.stripe = await loadStripe(this.stripeKey);
        this.elements = this.stripe.elements({ clientSecret: this.clientSecret,
            appearance: {
            theme: 'stripe',
            variables: {
                colorPrimary: '#000',      
                colorBackground: '#F4F7FA',   
                colorText: '#000',        
                colorDanger: '#dc2626',  
                borderRadius: '10px',
                spacingUnit: '6px',
            },
            rules: {
                '.Input': {
                    border: '1px solid #d1d5db',
                    boxShadow: 'none',
                    padding: '12px',
                    backgroundColor:'#fff'
                },
                '.Input:focus': {
                    border: '1px solid #4f46e5',
                    boxShadow: '0 0 0 3px rgba(79, 70, 229, 0.15)',
                },
                '.Label': {
                    color: '#000',
                    fontSize: '13px',
                    fontWeight: '600',
                    
                },
            },
        },
         });

        const paymentElement = this.elements.create('payment');
        paymentElement.mount(this.$refs.paymentElementRef);

        this.ready = true;
    },

    methods: {

        ...mapActions(['clearCart']),

        async handleSubmit() {
            this.loading = true;
            this.message = '';

            const { error } = await this.stripe.confirmPayment({
                elements: this.elements,
                confirmParams: {
                    return_url: `${window.location.origin}/payment-success`,
                },
            });

            if (error) {
                this.message = error.message;
            }
            this.loading = false;
        },
        goBack() {


            this.show();
        },
        show() {
            this.$refs.successTriggermodal.click();
        },
        hide() {
            this.$refs.closeTriggermodal.click();
        },
        gotoOrders() {
            this.hide();
            this.$inertia.visit(route('orders.show'));
        }
    },
};
</script>

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
<style scoped>
.payment-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #eef0f3;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    padding: 2rem;
}

.payment-header {
    text-align: center;
    margin-bottom: 1.5rem;
}

.lock-badge {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #eef2ff;
    color: #4f46e5;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
    font-size: 18px;
}

.amount-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8f9fb;
    border-radius: 10px;
    padding: 14px 16px;
    margin-bottom: 1.5rem;
}

.amount-label {
    font-size: 13px;
    color: #6b7280;
}

.amount-value {
    font-size: 18px;
    font-weight: 700;
    color: #111827;
}

.field-label {
    font-size: 13px;
    color: #374151;
    font-weight: 500;
    margin-bottom: 8px;
    display: block;
}

.stripe-field {
    border: 1px solid #d1d5db;
    border-radius: 10px;
    padding: 12px;
    background: #fff;
}

.btn-primary {
    border-radius: 8px;
    font-weight: 600;
}

.btn-outline-secondary {
    border-radius: 8px;
    font-weight: 600;
}

.secure-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 1.5rem;
    font-size: 12px;
    color: #9ca3af;
}
</style>