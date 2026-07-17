<template>
    <div class="fail-page d-flex align-items-center justify-content-center">
        <div class="fail-card text-center">
            <div class="icon-wrapper mx-auto mb-4">
                <svg width="44" height="44" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18M6 6L18 18" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <h1 class="fail-title mb-2">Payment Failed</h1>
            <p class="fail-subtitle mb-4">
                {{ message || "We couldn't process your payment. Your card has not been charged." }}
            </p>

            <div v-if="order" class="order-summary mx-auto mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="summary-label">Order Number</span>
                    <span class="summary-value">#{{ order.id }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="summary-label">Status</span>
                    <span class="badge-status">Payment Failed</span>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                <button class="btn-retry" @click="retryPayment">
                    Try Again
                </button>
                <button class="btn-cart" @click="backToCart">
                    Back to Cart
                </button>
            </div>

            <p class="support-note mt-4">
                Still having trouble? <a href="/contact" class="support-link">Contact support</a>
            </p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PaymentFailed',
    props: {
        order: {
            type: Object,
            default: null,
        },
        message: {
            type: String,
            default: '',
        },
    },
    methods: {
        retryPayment() {
            this.$inertia.visit('/checkout');
        },
        backToCart() {
            this.$inertia.visit('/cart');
        },
    },
};
</script>

<style scoped>
.fail-page {
    min-height: 100vh;
    background: linear-gradient(180deg, #fef2f2 0%, #fdf5f5 100%);
    padding: 24px;
}

.fail-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 48px 40px;
    max-width: 480px;
    width: 100%;
    box-shadow: 0 10px 40px rgba(51, 20, 20, 0.08);
}

.icon-wrapper {
    width: 84px;
    height: 84px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #ef4444, #dc2626, #7f1d1d);
}

.fail-title {
    font-family: 'Manrope', sans-serif;
    font-size: 24px;
    font-weight: 700;
    color: #14332f;
}

.fail-subtitle {
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    color: #6b7280;
    line-height: 1.6;
}

.order-summary {
    background: #fef2f2;
    border-radius: 12px;
    padding: 18px 20px;
    max-width: 340px;
}

.summary-label {
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    color: #4b5563;
}

.summary-value {
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: #14332f;
}

.badge-status {
    display: inline-block;
    background-color: #dc2626;
    color: #ffffff;
    font-size: 12px;
    font-weight: 600;
    padding: 3px 12px;
    border-radius: 999px;
}

.btn-retry {
    background-color: #0d9488;
    color: #ffffff;
    border: none;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 600;
    padding: 12px 28px;
    border-radius: 8px;
    transition: background-color 0.2s ease;
}

.btn-retry:hover {
    background-color: #14332f;
}

.btn-cart {
    background-color: transparent;
    color: #4b5563;
    border: 1.5px solid #d1d5db;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 600;
    padding: 12px 28px;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.btn-cart:hover {
    background-color: #f9fafb;
}

.support-note {
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    color: #9ca3af;
}

.support-link {
    color: #0d9488;
    font-weight: 600;
    text-decoration: none;
}

.support-link:hover {
    text-decoration: underline;
}
</style>