<template>
    <div class="success-page d-flex align-items-center justify-content-center">
        <div class="success-card text-center">
            <div class="icon-wrapper mx-auto mb-4">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 6L9 17L4 12" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <h1 class="success-title mb-2">Thank You For Your Payment</h1>
            <p class="success-subtitle mb-4">
                Your order has been placed successfully and a confirmation email is on its way.
            </p>

            <div class="order-summary mx-auto mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="summary-label">Order Number</span>
                    <span class="summary-value">#{{ order.order_number }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="summary-label">Amount Paid</span>
                    <span class="summary-value">Rs {{ order.total }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="summary-label">Status</span>
                    <span class="badge-status">{{ order.status_label }}</span>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                <button class="btn-view-order" @click="viewOrder">
                    View Order
                </button>
                <button class="btn-continue" @click="continueShopping">
                    Continue Shopping
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PaymentSuccess',
    props: {
        order: {
            type: Object,
            required: true,
        },
    },
    computed: {
  
    },
    methods: {
        viewOrder() {
            this.$inertia.visit(`/orders/${this.order.id}`);
        },
        continueShopping() {
            this.$inertia.visit('/');
        },
    },
};
</script>

<style scoped>
.success-page {
    min-height: 100vh;
    background: linear-gradient(180deg, #f0fdfa 0%, #e6f7f5 100%);
    padding: 24px;
}

.success-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 48px 40px;
    max-width: 480px;
    width: 100%;
    box-shadow: 0 10px 40px rgba(20, 51, 47, 0.08);
}

.icon-wrapper {
    width: 84px;
    height: 84px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: black;
}

.success-title {
    font-family: 'Manrope', sans-serif;
    font-size: 24px;
    font-weight: 700;
    color: #14332f;
}

.success-subtitle {
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    color: #6b7280;
    line-height: 1.6;
}

.order-summary {
    background: #f0fdfa;
    border-radius: 12px;
    padding: 18px 20px;
    max-width: 340px;
}

.summary-label {
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    color: #000000;
}

.summary-value {
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: #ffffff;
}

.badge-status {
    display: inline-block;
    background-color: #000000;
    color: #ffffff !important;
    font-size: 12px;
    font-weight: 600;
    padding: 3px 12px;
    border-radius: 999px;
}

.btn-view-order {
    background-color: #000000;
    color: #ffffff;
    border: none;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 600;
    padding: 12px 28px;
    border-radius: 8px;
    transition: background-color 0.2s ease;
}

.btn-view-order:hover {
    background-color: #14332f;
}

.btn-continue {
    background-color: transparent;
    color: #000000;
    border: 1.5px solid #000000;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 600;
    padding: 12px 28px;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.btn-continue:hover {
    background-color: #f0fdfa;
}
</style>