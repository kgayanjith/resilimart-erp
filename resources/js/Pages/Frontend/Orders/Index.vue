<template>
    <AppLayout>
        <div class="order-history container" style="max-width:900px;">

            <div class="page-header">
                <h1><span class="accent-mark">&#9679;</span> Order History</h1>
                <p>Every order you've placed, tracked from checkout to doorstep.</p>
            </div>

            <!-- Toolbar -->
            <div class="toolbar d-flex flex-wrap gap-2 align-items-center">
                <div class="input-group" style="max-width:280px;">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control  bg-white" placeholder="Search order ID..." v-model="search">
                </div>

                <select class="form-select bg-white" style="max-width:170px;" v-model="statusFilter">
                    <option value="all">All statuses</option>
                    <option value="delivered">Delivered</option>
                    <option value="shipped">Shipped</option>
                    <option value="processing">Processing</option>
                    <option value="cancelled">Cancelled</option>
                </select>

                <select class="form-select bg-white" style="max-width:170px;" v-model="sortBy">
                    <option value="newest">Newest first</option>
                    <option value="oldest">Oldest first</option>
                    <option value="highest">Highest price</option>
                    <option value="lowest">Lowest price</option>
                </select>

                <span class="ms-auto text-muted small mono">
                    {{ orders.length }} order{{ orders.length !== 1 ? 's' : '' }}
                </span>
            </div>

            <!-- Orders -->
            <div v-if="orders.length">
                <div class="ticket" v-for="order in orders" :key="order.id">
                    <div class="ticket-body">
                        <div class="row gy-3 align-items-center">
                            <div class="col-6 col-md-3">
                                <div class="meta-label">Order Number</div>
                                <div class="order-id">{{ order.order_number }}</div>
                            </div>

                            <div class="col-6 col-md-3">
                                <div class="meta-label">Status</div>
                                <span class="status-pill" :class="'status-' + order.status">
                                    <span class="status-dot"></span>{{ order.status }}
                                </span>
                            </div>

                            <div class="col-6 col-md-3">
                                <div class="meta-label">Placed on</div>
                                <div class="meta-value mono">{{ formatDate(order.created_at) }}</div>
                            </div>

                            <div class="col-6 col-md-3">
                                <div class="meta-label">Total</div>
                                <div class="price-value">Rs. {{ order.total }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="ticket-footer">
                        <div class="items-count">
                            <strong>{{ order.items.length }}</strong> item{{ order.items.length !== 1 ? 's' : '' }}
                        </div>
                        <div class="footer-actions d-flex gap-2">
                            <button class="btn-ticket" @click="toggleExpand(order.id)">
                                {{ expanded === order.id ? 'Hide items' : 'View items' }}
                                <i class="bi bi-chevron-down chevron ms-1"
                                    :class="{ rotated: expanded === order.id }"></i>
                            </button>

                            <button class="btn-ticket" @click="Tracking(order.id)"
                                v-if="order.status !== 'cancelled'">Track order</button>
                            <button class="btn-reorder bg-secondary" v-if="order.status === 'placed'"
                                @click="confirmCancel(order.id)">Cancel</button>
                            <button class="btn-reorder"
                                v-if="order.status === 'delivered' || order.status === 'cancelled'">Reorder</button>
                        </div>
                    </div>

                    <div class="item-list bg-white" v-if="expanded === order.id">
                        <div class="item-row" v-for="item in order.items" :key="item.id">
                            <span class="item-name">{{ item.product_name }} <span class="text-muted">&times;{{
                                item.quantity }}</span></span>
                            <span class="mono">Rs. {{ item.line_total }}</span>
                        </div>
                    </div>
                </div>

                <!-- <nav class="d-flex justify-content-center mt-4 mb-5" v-if="totalPages > 1">
                    <ul class="pagination">
                        <li class="page-item" :class="{ disabled: page === 1 }">
                            <button class="page-link" @click="page = Math.max(1, page - 1)">&laquo;</button>
                        </li>
                        <li class="page-item" v-for="p in totalPages" :key="p" :class="{ active: page === p }">
                            <button class="page-link" @click="page = p">{{ p }}</button>
                        </li>
                        <li class="page-item" :class="{ disabled: page === totalPages }">
                            <button class="page-link" @click="page = Math.min(totalPages, page + 1)">&raquo;</button>
                        </li>
                    </ul>
                </nav> -->
            </div>

            <!-- Empty state -->
            <div class="empty-state" v-else>
                <i class="bi bi-receipt"></i>
                <div class="fw-semibold text-body mb-1">No orders found</div>
                <div>Try a different search term or status filter.</div>
            </div>

        </div>
        <button type="button" class="d-none" ref="cancelModalTrigger" data-bs-toggle="modal"
            data-bs-target="#cancelOrderModal"></button>

        <div class="modal fade" id="cancelOrderModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content cancel-modal-content">
                    <button type="button" class="d-none" ref="cancelModalClose" data-bs-dismiss="modal"></button>

                    <div class="modal-body text-center py-5 px-4">
                        <div class="warn-wrap mx-auto mb-4">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>

                        <h4 class="cancel-title mb-2">Cancel this order?</h4>
                        <p class="cancel-sub mb-4">
                            This action can't be undone. Your order will be cancelled and won't be processed further.
                        </p>

                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                            <button type="button" class="btn-keep-order" data-bs-dismiss="modal">
                                No, Keep Order
                            </button>
                            <button type="button" class="btn-confirm-cancel" @click="cancelOrder(pendingCancelId)">
                                Yes, Cancel Order
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


export default {
    components: {
        AppLayout
    },
    props: {
        orders: Array
    },
    data() {
        return {
            search: '',
            statusFilter: 'all',
            sortBy: 'newest',
            expanded: null,
            pendingCancelId: null,
        };
    },
    computed: {
        // filteredOrders() {
        //     let list = this.orders.filter((o) => {
        //         const matchesSearch = o.id.toLowerCase().includes(this.search.toLowerCase());
        //         const matchesStatus = this.statusFilter === 'all' || o.status === this.statusFilter;
        //         return matchesSearch && matchesStatus;
        //     });
        //     list = list.slice().sort((a, b) => {
        //         if (this.sortBy === 'newest') return new Date(b.placedDate) - new Date(a.placedDate);
        //         if (this.sortBy === 'oldest') return new Date(a.placedDate) - new Date(b.placedDate);
        //         if (this.sortBy === 'highest') return b.price - a.price;
        //         if (this.sortBy === 'lowest') return a.price - b.price;
        //         return 0;
        //     });
        //     return list;
        // },
        // totalPages() {
        //     return Math.ceil(this.filteredOrders.length / this.perPage) || 1;
        // },
        // paginatedOrders() {
        //     const start = (this.page - 1) * this.perPage;
        //     return this.filteredOrders.slice(start, start + this.perPage);
        // },
    },
    watch: {
        // filteredOrders() {
        //     this.page = 1;
        // },
    },
    methods: {
        toggleExpand(id) {
            this.expanded = this.expanded === id ? null : id;
        },
        statusLabel(status) {
            return status.charAt(0).toUpperCase() + status.slice(1);
        },
        formatDate(dateStr) {
            const d = new Date(dateStr);
            return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        },
        Tracking(id) {
            // console.log(id);
            this.$inertia.visit(route('order.track', id));
        },
        confirmCancel(id) {
            this.pendingCancelId = id;
            this.$refs.cancelModalTrigger.click();
        },
        cancelOrder(id) {
            this.$inertia.patch(route('order.cancel', id));
            this.$refs.cancelModalClose.click();
        }
    },
};
</script>

<style scoped>
.order-history {
    --bg: #f7f6f2;
    --surface: #ffffff;
    --surface-raised: #f2f0ea;
    --border: #e2ded4;
    --text: #1c1b18;
    --text-muted: #87837a;
    --accent: #a8671a;
    --success: #2f8a5c;
    --success-dim: #e3f3ea;
    --warning: #a8671a;
    --warning-dim: #f7e6cd;
    --danger: #c23b3b;
    --danger-dim: #fbe6e6;
    --info: #3868c9;
    --info-dim: #e5edfb;
    color: var(--text);
    --confirmed: #3868c9;
    --confirmed-dim: #e5edfb;

    --processing: #a8671a;
    --processing-dim: #f7e6cd;

    --shipping: #7c4fd6;
    --shipping-dim: #ede5fb;

    --delivered: #2f8a5c;
    --delivered-dim: #e3f3ea;

    --rejected: #c23b3b;
    --rejected-dim: #fbe6e6;

    --cancelled: #6b675f;
    --cancelled-dim: #eceae4;

    --placed: #3868c9;
    --placed-dim: #e5edfb;
}



.page-header {
    border-bottom: 1px solid var(--border);
    padding: 2rem 0 1.5rem;
}

.page-header h1 {
    font-weight: 700;
    letter-spacing: -0.02em;
    font-size: 1.9rem;
    margin-bottom: 0.15rem;
}

.page-header p {
    color: var(--text-muted);
    margin: 0;
    font-size: 0.92rem;
}

.accent-mark {
    color: var(--accent);
}

.toolbar {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 0.9rem 1rem;
    margin: 1.5rem 0;
}

.toolbar .form-control,
.toolbar .form-select {
    background: var(--surface-raised);
    border: 1px solid var(--border);
    color: var(--text);
    font-size: 0.9rem;
}

.toolbar .input-group-text {
    background: var(--surface-raised);
    border: 1px solid var(--border);
    color: var(--text-muted);
}

.ticket {
    position: relative;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    margin-bottom: 1.1rem;
    overflow: hidden;
}



.ticket-body {
    padding: 1.1rem 1.25rem 1rem;
}

.order-id {
    font-weight: 600;
    font-size: 0.8rem;
}

.order-id .hash {
    color: var(--text-muted);
    font-weight: 400;
}

.meta-label {
    text-transform: uppercase;
    font-size: 0.68rem;
    letter-spacing: 0.08em;
    color: var(--text-muted);
    margin-bottom: 0.15rem;
}

.meta-value {
    font-size: 0.92rem;
    font-weight: 500;
}

.price-value {
    font-weight: 600;
    font-size: 1.05rem;
}

.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.3rem 0.65rem;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 600;
}

.status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    flex-shrink: 0;
}

.status-confirmed {
    background: var(--confirmed-dim);
    color: var(--confirmed);
}

.status-confirmed .status-dot {
    background: var(--confirmed);
}

.status-processing {
    background: var(--processing-dim);
    color: var(--processing);
}

.status-processing .status-dot {
    background: var(--processing);
    animation: pulse 1.6s infinite;
}

.status-shipping {
    background: var(--shipping-dim);
    color: var(--shipping);
}

.status-shipping .status-dot {
    background: var(--shipping);
}

.status-delivered {
    background: var(--delivered-dim);
    color: var(--delivered);
}

.status-delivered .status-dot {
    background: var(--delivered);
}

.status-rejected {
    background: var(--rejected-dim);
    color: var(--rejected);
}

.status-rejected .status-dot {
    background: var(--rejected);
}

.status-cancelled {
    background: var(--cancelled-dim);
    color: var(--cancelled);
}

.status-cancelled .status-dot {
    background: var(--cancelled);
}

.status-placed {
    background: var(--placed-dim);
    color: var(--placed);
}

.status-placed .status-dot {
    background: var(--placed);
}

@keyframes pulse {

    0%,
    100% {
        opacity: 1;
    }

    50% {
        opacity: 0.35;
    }
}

.ticket-footer {
    padding: 0.65rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: rgba(0, 0, 0, 0.02);
    border-top: 1px dashed var(--border);
}

.items-count {
    color: var(--text-muted);
    font-size: 0.85rem;
}

.items-count strong {
    color: var(--text);
    font-weight: 600;
}

.btn-ticket {
    background: transparent;
    border: 1px solid var(--border);
    color: var(--text);
    font-size: 0.82rem;
    font-weight: 500;
    padding: 0.35rem 0.8rem;
    border-radius: 7px;
}

.btn-ticket:hover {
    border-color: var(--accent);
    color: var(--accent);
}

.btn-reorder {
    background: black;
    border: 1px solid black;
    color: #fffaf2;
    font-weight: 600;
    font-size: 0.82rem;
    padding: 0.35rem 0.9rem;
    border-radius: 7px;
}

.btn-reorder:hover {
    background: #8f5714;
    border-color: #8f5714;
}

.item-list {
    padding: 0.9rem 1.25rem 1.1rem;
    background: rgba(0, 0, 0, 0.02);
    border-top: 1px dashed var(--border);
}

.item-row {
    display: flex;
    justify-content: space-between;
    padding: 0.4rem 0;
    font-size: 0.87rem;
    color: var(--text-muted);
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.item-row:last-child {
    border-bottom: none;
}

.item-row .item-name {
    color: var(--text);
}

.chevron {
    transition: transform 0.2s ease;
}

.chevron.rotated {
    transform: rotate(180deg);
}

.empty-state {
    text-align: center;
    padding: 4rem 1rem;
    color: var(--text-muted);
}

.empty-state i {
    font-size: 2.4rem;
    color: var(--border);
    margin-bottom: 0.75rem;
    display: block;
}

.pagination .page-link {
    background: var(--surface);
    border: 1px solid var(--border);
    color: var(--text-muted);
}

.pagination .page-item.active .page-link {
    background: var(--accent);
    border-color: var(--accent);
    color: #fffaf2;
    font-weight: 600;
}

@media (max-width: 576px) {
    .ticket-footer {
        flex-direction: column;
        align-items: stretch;
        gap: 0.6rem;
    }

    .footer-actions {
        display: flex;
        gap: 0.5rem;
    }

    .footer-actions .btn-ticket,
    .footer-actions .btn-reorder {
        flex: 1;
    }
}

.cancel-modal-content {
    border: none;
    border-radius: 20px;
    box-shadow: 0 24px 60px -12px rgba(5, 19, 18, 0.35);
}

.warn-wrap {
    width: 76px;
    height: 76px;
    border-radius: 50%;
    background: #fef2f2;
    display: flex;
    align-items: center;
    justify-content: center;
}

.warn-wrap i {
    font-size: 1.9rem;
    color: #dc2626;
}

.cancel-title {
    font-family: 'Manrope', sans-serif;
    font-weight: 700;
    color: #14332f;
}

.cancel-sub {
    font-size: 0.9rem;
    color: #6b7c7a;
    line-height: 1.6;
    max-width: 320px;
    margin-left: auto;
    margin-right: auto;
}

.btn-keep-order {
    padding: 0.65rem 1.4rem;
    font-size: 0.88rem;
    font-weight: 600;
    color: #274b47;
    background: #f6f9f8;
    border: 1.5px solid #e3ebea;
    border-radius: 10px;
    transition: border-color 0.15s ease, background 0.15s ease;
}

.btn-keep-order:hover {
    border-color: #b9d9d5;
    background: #eef5f4;
}

.btn-confirm-cancel {
    padding: 0.65rem 1.4rem;
    font-size: 0.88rem;
    font-weight: 600;
    color: #ffffff;
    background: #dc2626;
    border: none;
    border-radius: 10px;
    transition: transform 0.12s ease, box-shadow 0.12s ease;
    box-shadow: 0 8px 20px -6px rgba(220, 38, 38, 0.4);
}

.btn-confirm-cancel:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 24px -6px rgba(220, 38, 38, 0.5);
}
</style>