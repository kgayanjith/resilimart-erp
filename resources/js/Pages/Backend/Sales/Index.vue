<template>
    <AppLayout>
        <main>
            <HeaderComponent title="Sales" subtitle="Manage Sales" />
            <div class="table-responsive">
                <table class="table table-hover" id="bannersTable">
                    <thead class="">
                        <tr>
                            <th class="fw-bold text-start" scope="col">Order Number</th>
                            <th class="fw-bold" scope="col">Customer Name</th>
                            <th class="fw-bold text-center" scope="col">Payment Type</th>
                            <th class="fw-bold text-center" scope="col">Placed Date</th>
                            <th class="fw-bold text-center" scope="col">Payment Status</th>
                            <th class="fw-bold text-center" scope="col">Status</th>
                            <th class="fw-bold" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="sale in sales" :key="sale.id">
                            <td class="text-start">{{ sale.order_number }}</td>
                            <td class="text-start">{{ sale.customer.name }}</td>
                            <td class="text-center">
                                {{ sale.payment_method === 'cod' ? 'Cash on Delivery' : sale.payment_method ===
                                    'bank_transfer' ? 'Bank Transfer' : sale.payment_method === 'card' ? 'Credit / Debit Card' : sale.payment_method }}
                            </td>

                            <td class="text-center">{{ formatDate(sale.created_at) }}</td>
                            <td class="text-center payment">
                                <span class="status-badge" :class="'status-' + sale.payment_status">
                                    {{ sale.payment_status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="status-badge" :class="'status-' + sale.status">
                                    {{ sale.status }}
                                </span>
                            </td>

                            <td>
                                <Link class="btn-sm btn-secondary btn" @click="view(sale.id)">View</Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </AppLayout>
</template>

<script>
import HeaderComponent from '@/Components/HeaderComponent.vue';
import AppLayout from '@/Layouts/SideNavBar.vue';
import { Link } from '@inertiajs/vue3';



export default {
    components: {
        HeaderComponent,
        AppLayout,
        Link
    },
    data() {
        return {

        }
    },
    props: {
        sales: Array
    },
    computed: {
        paymentMethodLabel(method) {
            const map = {
                cod: 'Cash on Delivery',
                card: 'Credit / Debit Card',
                bank_transfer: 'Bank Transfer'
            };
            return map[method] || method;
        }
    },
    mounted() {

        const vm = this;

        $(document).ready(function () {
            $('#bannersTable').DataTable();
        });

        // $("#bannersTable").on("click", ".action_edit", function (evt) {
        //     evt.preventDefault();
        //     const id = $(this).data("id");
        //     vm.$inertia.visit(route("banner.edit", id));
        //     // console.log(id);
        // });
    },
    methods: {
        // deleteCategory(selectedId) {
        //     // console.log(selectedId);
        //     this.$inertia.delete(route("banner.delete", selectedId), {
        //         onSuccess: () => {
        //             const modal = bootstrap.Modal.getInstance(document.getElementById('staticBackdropbanner'));
        //             modal.hide();

        //         }
        //     });
        // },

        formatDate(dateStr) {
            const d = new Date(dateStr);
            return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        },

        view(id) {
            this.$inertia.visit(route("sale.view", id));
        }
    }

}
</script>

<style scoped>
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: capitalize;
    padding: 0.3rem 0.8rem;
    border-radius: 999px;
    white-space: nowrap;
}

.status-badge::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
}

.status-placed {
    background: #eef2ff;
    color: #4338ca;
}

.status-placed::before {
    background: #4338ca;
}

.status-confirmed {
    background: #f0faf8;
    color: #0d9488;
}

.status-confirmed::before {
    background: #940d0d;
}
.status-rejected {
    background: #fdbbbb;
    color: #0d9488;
}

.status-rejected::before {
    background: #0d9488;
}

.status-processing {
    background: #fffbeb;
    color: #b45309;
}

.status-processing::before {
    background: #b45309;
    animation: status-pulse 1.6s infinite;
}

.status-shipping {
    background: #eff6ff;
    color: #1d4ed8;
}

.status-shipping::before {
    background: #1d4ed8;
}

.status-delivered {
    background: #f0fdf4;
    color: #16a34a;
}

.status-delivered::before {
    background: #16a34a;
}

.status-cancelled {
    background: #fef2f2;
    color: #dc2626;
}

.status-cancelled::before {
    background: #dc2626;
}

@keyframes status-pulse {

    0%,
    100% {
        opacity: 1;
    }

    50% {
        opacity: 0.3;
    }
}
.payment .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: capitalize;
    padding: 0.3rem 0.8rem;
    border-radius: 999px;
    white-space: nowrap;
}

.payment .status-badge::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
}

.status-pending {
    background: #fffbeb;
    color: #b45309;
}
.status-pending::before {
    background: #b45309;
}

.status-paid {
    background: #9afbd0;
    color: #16a34a;
}
.status-paid::before {
     background: #16a34a;
  
}
</style>