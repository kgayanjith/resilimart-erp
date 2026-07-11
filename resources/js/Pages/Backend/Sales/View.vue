<template>
    <AppLayout>
        <div class="order-view-page">
            <div class="container-fluid px-lg-4 py-4">

                <!-- Back link + page header -->
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                    <div>
                        <Link :href="route('sales.index')"
                            class="back-link mb-4 d-inline-flex align-items-center text-black">
                        <i class="fa-solid fa-arrow-left me-2"></i>Back to Sales
                        </Link>
                        <h3 class="page-title mb-1">Order {{ sale.order_number }}</h3>
                        <p class="page-sub mb-0">Placed on {{ formatDate(sale.created_at) }}</p>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="status-badge status-processing">{{ sale.status }}</span>
                        <span class="payment-badge payment-pending">Payment {{ sale.payment_status }}</span>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="admin-card border  mb-4">
                            <h5 class="card-heading mb-3">Customer</h5>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="customer-avatar">KG</div>
                                <div>
                                    <p class="customer-name mb-0">{{ sale.customer.name }}</p>
                                    <p class="customer-email mb-0">{{ sale.customer.email }}</p>
                                </div>
                            </div>
                            <div class="info-row">
                                <i class="fa-solid fa-phone"></i>
                                <span>{{ sale.customer.phone }}</span>

                            </div>
                            <a :href="`tel:${sale.customer.phone}`" class="btn btn-primary rounded-3 w-100 mt-3">Call
                                now</a>
                        </div>




                    </div>
                    <div class="col-lg-4">
                        <!-- Shipping address -->
                        <div class="admin-card border  mb-4">
                            <h5 class="card-heading mb-3">Shipping Address</h5>
                            <p class="address-text mb-0">
                                {{ sale.customer.address }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Payment info -->
                        <div class="admin-card border">
                            <h5 class="card-heading mb-3">Payment Details</h5>
                            <div class="info-row">
                                <span>Method</span>
                                <strong>{{ sale.payment_method }}</strong>
                            </div>
                            <div class="info-row">
                                <span>Status</span>
                                <span class="payment-badge payment-pending">{{ sale.payment_status }}</span>
                            </div>
                            <button class="btn-mark-paid w-100 mt-3">
                                <i class="fa-solid fa-check me-1"></i>Mark as Paid
                            </button>
                        </div>
                    </div>
                    <!-- Left column -->
                    <div class="col-lg-8">

                        <!-- Order items -->
                        <div class="admin-card mb-4 border">
                            <h5 class="card-heading mb-3">Order Items</h5>
                            <div class="table-responsive">
                                <table class="items-table w-100">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Unit Price</th>
                                            <th>Qty</th>
                                            <th class="text-end">Line Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in sale.items" :key="item.id">
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="item-thumb">
                                                        <img :src="item.product.media[0].original_url"
                                                            :alt="item.product.name">
                                                    </div>
                                                    <div>
                                                        <p class="item-name mb-0">{{ item.product.name }}</p>

                                                    </div>
                                                </div>
                                            </td>
                                            <td>Rs {{ item.unit_price }}</td>
                                            <td>{{ item.quantity }}</td>
                                            <td class="text-end">Rs {{ item.line_total }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="totals-block mt-3">
                                <div class="totals-row">
                                    <span>Subtotal</span>
                                    <span>Rs {{ sale.subtotal }}</span>
                                </div>
                                <div class="totals-row">
                                    <span>VAT (18%)</span>
                                    <span>Rs {{ sale.vat_amount }}</span>
                                </div>
                                <div class="totals-row totals-final">
                                    <span>Total</span>
                                    <span class="fw-bold">Rs {{ sale.total }}</span>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- Right column -->
                    <div class="col-lg-4">
                        <div class="admin-card border mb-4">
                            <h5 class="card-heading mb-3">Update Status</h5>
                            <select class="status-select w-100 mb-3" v-model="selectedStatus">
                                <option value="placed">Placed</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="processing">Processing</option>
                                <option value="shipping">Shipping</option>
                                <option value="delivered">Delivered</option>
                                <option value="rejected">Rejected</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <button class="btn-update-status w-100" @click="updateStatus" :disabled="updating || this.selectedStatus == sale.status">
                                {{ updating ? 'Updating...' : 'Update Order' }}
                            </button>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/SideNavBar.vue';
import { Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

export default {
    components: {
        AppLayout,
        Link
    },
    props: {
        sale: Object
    },
    data() {
        return {
            selectedStatus: this.sale.status,
            updating: false
        }
    },
    methods: {
        formatDate(dateStr) {
            const d = new Date(dateStr);
            return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        },
        updateStatus() {
            this.updating = true;

            this.$inertia.patch(route('sale.status.update', this.sale.id), {
                status: this.selectedStatus
            }, {
                preserveScroll: true,
                onSuccess: () => {
                    this.updating = false;
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        },
                    });
                    Toast.fire({
                        icon: "success",
                        title: "Status Saved",
                        text: "Status has been chnaged successfully.",
                        iconColor: "#2563eb",
                        customClass: {
                            timerProgressBar: "custom-timer-bar",
                        },
                    });
                },
                onError: () => {
                    this.updating = false;
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        },
                    });
                    Toast.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Something went wrong!",
                        iconColor: "#2563eb",
                        customClass: {
                            timerProgressBar: "custom-timer-bar",
                        },
                    });
                }
            });
        }
    }
}
</script>
<style scoped>
.order-view-page {
    background: #ffffff;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
}

.back-link {
    font-size: 0.85rem;
    font-weight: 600;
    color: #0d9488;
    text-decoration: none;
}

.back-link:hover {
    color: #0f766e;
    text-decoration: underline;
}

.page-title {
    font-family: 'Manrope', sans-serif;
    font-weight: 700;
    color: #14332f;
}

.page-sub {
    font-size: 0.85rem;
    color: #7c9390;
}

.admin-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 8px 24px -10px rgba(5, 19, 18, 0.08);
}

.card-heading {
    font-family: 'Manrope', sans-serif;
    font-weight: 700;
    color: #14332f;
}

/* Status / payment badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: capitalize;
    padding: 0.35rem 0.85rem;
    border-radius: 999px;
}

.status-badge::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.status-processing {
    background: #fffbeb;
    color: #b45309;
}

.status-processing::before {
    background: #b45309;
    animation: pulse 1.6s infinite;
}

@keyframes pulse {

    0%,
    100% {
        opacity: 1;
    }

    50% {
        opacity: 0.3;
    }
}

.payment-badge {
    display: inline-flex;
    align-items: center;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.3rem 0.75rem;
    border-radius: 6px;
}

.payment-pending {
    background: #fffbeb;
    color: #b45309;
    border: 1px solid #fde8b8;
}

/* Items table */
.items-table {
    border-collapse: collapse;
}

.items-table th {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #8fa3a0;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #eef3f2;
    text-align: left;
}

.items-table td {
    padding: 0.9rem 0;
    border-bottom: 1px solid #eef3f2;
    font-size: 0.88rem;
    color: #14332f;
    vertical-align: middle;
}

.items-table tr:last-child td {
    border-bottom: none;
}

.item-thumb {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    overflow: hidden;
    background: #f6f9f8;
    flex-shrink: 0;
}

.item-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.item-name {
    font-weight: 600;
    font-size: 0.87rem;
    color: #14332f;
}

.item-sku {
    font-size: 0.76rem;
    color: #9aa8a6;
}

/* Totals */
.totals-block {
    max-width: 280px;
    margin-left: auto;
}

.totals-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.87rem;
    color: #4b615e;
    margin-bottom: 0.5rem;
}

.totals-final {
    font-family: 'Manrope', sans-serif;
    font-weight: 700;
    font-size: 1rem;
    color: #14332f;
    padding-top: 0.5rem;
    border-top: 1px solid #eef3f2;
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: 1.5rem;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.75rem;
    padding-left: 1.25rem;
    border-left: 2px solid #e6edec;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-dot {
    position: absolute;
    left: -7px;
    top: 2px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #e6edec;
    border: 2px solid #ffffff;
    box-shadow: 0 0 0 2px #e6edec;
}

.timeline-item.done .timeline-dot {
    background: #14b8a6;
    box-shadow: 0 0 0 2px #14b8a6;
}

.timeline-item.active .timeline-dot {
    background: #0d9488;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.2);
}

.timeline-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #9aa8a6;
}

.timeline-item.done .timeline-label,
.timeline-item.active .timeline-label {
    color: #14332f;
}

.timeline-date {
    font-size: 0.78rem;
    color: #9aa8a6;
}

/* Status update */
.status-select {
    padding: 0.65rem 0.9rem;
    font-size: 0.9rem;
    color: #14332f;
    background: #f6f9f8;
    border: 1.5px solid #e3ebea;
    border-radius: 10px;
}

.status-select:focus {
    outline: none;
    border-color: #14b8a6;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.12);
}

.btn-update-status {
    padding: 0.7rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: #ffffff;
    background: black;
    border: none;
    border-radius: 10px;
    transition: transform 0.12s ease, box-shadow 0.12s ease;
}

.btn-update-status:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px -6px rgba(13, 148, 136, 0.45);
}

.btn-update-status:disabled{
    cursor: not-allowed;
    background: rgb(80, 80, 80);
}

/* Customer */
.customer-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: black;
    color: #ffffff;
    font-family: 'Manrope', sans-serif;
    font-weight: 700;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.customer-name {
    font-weight: 600;
    font-size: 0.9rem;
    color: #14332f;
}

.customer-email {
    font-size: 0.8rem;
    color: #7c9390;
}

.info-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.85rem;
    color: #4b615e;
    padding: 0.4rem 0;
}

.info-row i {
    color: #0d9488;
    width: 16px;
    margin-right: 0.5rem;
}

/* Address */
.address-text {
    font-size: 0.88rem;
    color: #14332f;
    line-height: 1.7;
}

/* Mark as paid */
.btn-mark-paid {
    padding: 0.6rem;
    font-size: 0.85rem;
    font-weight: 600;
    color: #4d4d4d;
    background: #eaeaea;
    border: 1.5px solid #4d4d4d;
    border-radius: 10px;
    transition: background 0.15s ease;
}

.btn-mark-paid:hover {
    background: #dfdfdf;
}
</style>