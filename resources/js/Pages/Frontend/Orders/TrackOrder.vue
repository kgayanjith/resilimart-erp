<template>
    <AppLayout>
        <div class="container-fluid px-lg-5 mt-5 route-page">
            <div class="route-inner">
                <div class="route-header">
                    <div>
                        <div class="eyebrow">Tracking</div>
                        <h2 class="route-title">Order <span class="accent">{{ order.order_number }}</span></h2>
                    </div>
                    <span class="status-chip">Order {{ order.status }}</span>
                </div>

                <div class="route-track">
                    <div class="road"></div>
                    <div class="road-fill" :style="{ width: statusWidths[order.status] + '%' }"></div>

                    <div class="marker" :style="{ left: statusWidths[order.status] + '%' }">
                        <div class="marker-pulse"></div>
                        <i class="bi bi-truck"></i>
                    </div>

                    <div class="stop" :class="{ 'stop-current': order.status === 'placed' }" style="left: 0%;">
                        <div class="stop-dot"><i class="bi bi-receipt"></i></div>
                        <div class="stop-label">Placed</div>

                    </div>

                    <div class="stop" :class="{ 'stop-current': order.status === 'confirmed' }" style="left: 25%;">
                        <div class="stop-dot"><i class="bi bi-check-lg"></i></div>
                        <div class="stop-label">Confirmed</div>

                    </div>

                    <div class="stop" :class="{ 'stop-current': order.status === 'processing' }" style="left: 50%;">
                        <div class="stop-dot"><i class="bi bi-arrow-repeat"></i></div>
                        <div class="stop-label">Processing</div>

                    </div>

                    <div class="stop" :class="{ 'stop-current': order.status === 'shipping' }" style="left: 75%;">
                        <div class="stop-dot"><i class="bi bi-truck"></i></div>
                        <div class="stop-label">Shipping</div>

                    </div>

                    <div class="stop" :class="{ 'stop-current': order.status === 'delivered' }" style="left: 100%;">
                        <div class="stop-dot"><i class="bi bi-box-seam"></i></div>
                        <div class="stop-label">Delivered</div>

                    </div>
                </div>
                <div class="items-card">
                    <div class="items-title">Items in this order</div>

                    <div class="item-row" v-for="item in order.items" :key="item.id">
                        <img :src="item.product.media[0].original_url" :alt="item.product.name" class="item-img" />
                        <div class="item-info">
                            <div class="item-name">{{ item.product.name }}</div>
                            <div class="item-meta mono">Qty {{ item.product.quantity }} &middot; Rs. {{ item.unit_price
                            }}</div>
                        </div>
                        <div class="item-total mono">Rs. {{ item.line_total }}</div>
                    </div>

                    <div class="items-summary">
                        <span>Order total</span>
                        <span class="mono fw-bold">Rs. {{ order.total }}</span>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>

</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';


export default {
    components: {
        AppLayout
    },
    props: {
        order: Array
    },
    data() {
        return {
            statusWidths: {
                placed: 0,
                confirmed: 25,
                processing: 50,
                shipping: 75,
                delivered: 100,
            },
        };
    },
};
</script>

<style scoped>
.route-page {
    --bg: #f7f6f2;
    --surface: #ffffff;
    --border: #e2ded4;
    --text: #1c1b18;
    --text-muted: #87837a;
    --accent: #a8671a;
    --accent-dim: #f7e6cd;
    color: var(--text);
    font-family: 'Inter', sans-serif;
}

.route-inner {
    max-width: 900px;
    margin: 0 auto;
}

/* header */
.route-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2.5rem;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.eyebrow {
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 0.1em;
    color: var(--text-muted);
    margin-bottom: 0.2rem;
}

.route-title {
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 700;
    font-size: 1.6rem;
    margin: 0;
}

.route-title .accent {
    color: var(--accent);
    font-family: 'IBM Plex Mono', monospace;
}

.status-chip {
    background: var(--accent-dim);
    color: var(--accent);
    font-size: 0.8rem;
    font-weight: 600;
    padding: 0.35rem 0.9rem;
    border-radius: 20px;
}

/* horizontal route */
.route-track {
    position: relative;
    height: 130px;
    margin: 0 1rem 4rem;
}

.road {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--border);
    border-radius: 2px;
}

.road-fill {
    position: absolute;
    top: 0;
    left: 0;
    height: 3px;
    background: var(--accent);
    border-radius: 2px;
    transition: width 1.2s cubic-bezier(.4, 0, .2, 1);
}

.marker {
    position: absolute;
    top: -17px;
    transform: translateX(-50%);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--accent);
    color: #fffaf2;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.05rem;
    box-shadow: 0 4px 10px rgba(168, 103, 26, 0.35);
    transition: left 1.2s cubic-bezier(.4, 0, .2, 1);
    animation: bob 2s ease-in-out infinite;
    z-index: 2;
}

@keyframes bob {

    0%,
    100% {
        transform: translateX(-50%) translateY(0);
    }

    50% {
        transform: translateX(-50%) translateY(-5px);
    }
}

.marker-pulse {
    position: absolute;
    inset: -8px;
    border-radius: 50%;
    border: 2px solid var(--accent);
    animation: ping 1.8s cubic-bezier(0, 0, .2, 1) infinite;
}

@keyframes ping {
    0% {
        transform: scale(0.85);
        opacity: 0.7;
    }

    100% {
        transform: scale(1.7);
        opacity: 0;
    }
}

.stop {
    position: absolute;
    top: 26px;
    transform: translateX(-50%);
    text-align: center;
    width: 110px;
}

.stop-dot {
    width: 26px;
    height: 26px;
    margin: 0 auto 0.6rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    background: var(--surface);
    border: 2px solid var(--border);
    color: var(--text-muted);
}

.stop-done .stop-dot {
    background: var(--accent);
    border-color: var(--accent);
    color: #fffaf2;
}

.stop-current .stop-dot {
    border-color: var(--accent);
    color: var(--accent);
    background: var(--accent-dim);
}

.stop-label {
    font-size: 0.83rem;
    font-weight: 600;
}

.stop-upcoming .stop-label,
.stop-upcoming .stop-time {
    color: var(--text-muted);
}

.stop-time {
    font-size: 0.7rem;
    color: var(--text-muted);
    margin-top: 0.15rem;
}

/* feed card */
.feed-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.feed-title {
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 1.1rem;
}

.feed-item {
    display: flex;
    gap: 0.85rem;
    padding-bottom: 1.1rem;
    margin-bottom: 1.1rem;
    border-bottom: 1px dashed var(--border);
}

.feed-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.feed-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: var(--border);
    margin-top: 0.4rem;
    flex-shrink: 0;
}

.feed-dot-live {
    background: var(--accent);
    box-shadow: 0 0 0 4px var(--accent-dim);
    animation: livedot 1.8s infinite;
}

@keyframes livedot {

    0%,
    100% {
        box-shadow: 0 0 0 4px var(--accent-dim);
    }

    50% {
        box-shadow: 0 0 0 7px transparent;
    }
}

.feed-text {
    font-size: 0.9rem;
}

.feed-time {
    font-size: 0.75rem;
    color: var(--text-muted);
    margin-top: 0.15rem;
}

/* responsive: stack the route vertically on small screens */
@media (max-width: 640px) {
    .route-track {
        height: auto;
        margin-bottom: 2rem;
    }

    .road,
    .road-fill {
        top: 0;
        bottom: 0;
        left: 12px;
        width: 3px !important;
        height: auto !important;
    }

    .marker {
        left: 12px !important;
        top: var(--m-top, 0);
    }

    .stop {
        position: static;
        transform: none;
        width: auto;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .stop-dot {
        margin: 0;
    }
}

.items-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.items-title {
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 1.1rem;
}

.item-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.85rem 0;
    border-bottom: 1px dashed var(--border);
}

.item-row:last-of-type {
    border-bottom: none;
}

.item-img {
    width: 56px;
    height: 56px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid var(--border);
    flex-shrink: 0;
    background: var(--bg);
}

.item-info {
    flex: 1;
    min-width: 0;
}

.item-name {
    font-size: 0.9rem;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.item-meta {
    font-size: 0.78rem;
    color: var(--text-muted);
    margin-top: 0.2rem;
}

.item-total {
    font-size: 0.88rem;
    font-weight: 600;
    flex-shrink: 0;
}

.items-summary {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    margin-top: 0.4rem;
    font-size: 0.95rem;
    font-weight: 600;
}
</style>