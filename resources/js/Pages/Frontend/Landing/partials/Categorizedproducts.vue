<template>
    <div class="container-fluid px-lg-5 mt-5">
        <div v-if="productsections && productsections.length">
            <div v-for="prodsection in productsections" :key="prodsection.id" class="mb-5">
                <div>
                    <h3 class="">{{ prodsection.name }}</h3>
                </div>

                <div v-if="prodsection.products && prodsection.products.length" class="row mt-5">
                    <div class="col-md-3 mb-3" v-for="product in prodsection.products" :key="product.id">
                        <div class="product-wrapper">
                            <Link class="card rounded-4 p-1" @click="productView(product.id)">
                            <img :src="product.media[0]?.original_url" class="card-img-top w-100 rounded-3" alt="...">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <p class="product-category-text">{{ product.category.name }}</p>
                                    </div>
                                    <div>
                                        <h5 class="card-title">Rs {{ product.price }}.00</h5>
                                    </div>
                                </div>

                                <h4 class="card-title comfortaa text-truncate">{{ product.name }}</h4>
                                <div class="mb-2 d-flex align-items-center">
                                    <div class="stars">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    </div>
                                    <div class="review-count">
                                        <p class="mb-0 ps-1">4.0</p>
                                    </div>
                                </div>
                                <p class="card-text two-line-clamp">{{ product.description }}</p>

                                <div class="buy-bar w-100 mt-3">
                                    <button @click.stop.prevent="addToCart(product)" :disabled="isInCart(product.id)"
                                        class="buy-link w-100">
                                        {{ isInCart(product.id) ? 'Already in Cart' : 'Add to Cart' }}
                                    </button>
                                </div>
                            </div>
                            </Link>
                        </div>
                    </div>
                </div>

                <div v-else class="section-empty text-center mt-4">
                    <i class="fa-solid fa-box-open me-2"></i>
                    <span>No products in {{ prodsection.name }} yet.</span>
                </div>
            </div>
        </div>

        <div v-else class="empty-state text-center">
            <div class="empty-icon-wrap mx-auto mb-4">
                <i class="fa-solid fa-grip"></i>
            </div>
            <h4 class="empty-title">Nothing to show yet</h4>
            <p class="empty-sub mx-auto">
                Product sections will appear here once they're added.
            </p>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import { mapState, mapActions } from 'vuex';

export default {
    components: {
        Link
    },
    props: {
        productsections: Object,
    },
    computed: {
        ...mapState({
            cartItems: state => state.cartItems
        })
    },
    methods: {
        ...mapActions(['addToCart']),

        isInCart(productId) {
            return this.cartItems.some(item => item.id === productId);
        },
         productView(id) {
            this.$inertia.visit(route('product.view', id));
        }
    }
}
</script>

<style scoped>
.section-empty {
    padding: 1.5rem;
    background: #f6f9f8;
    border: 1px dashed #d9e6e4;
    border-radius: 12px;
    color: #6b7c7a;
    font-size: 0.9rem;
}

.section-empty i {
    color: #0d9488;
}

.empty-state {
    padding: 5rem 1rem;
}

.empty-icon-wrap {
    width: 84px;
    height: 84px;
    border-radius: 50%;
    background: #e6f5f2;
    display: flex;
    align-items: center;
    justify-content: center;
}

.empty-icon-wrap i {
    font-size: 1.9rem;
    color: #0d9488;
}

.empty-title {
    font-family: 'Manrope', sans-serif;
    font-weight: 700;
    color: #14332f;
    margin-bottom: 0.6rem;
}

.empty-sub {
    font-size: 0.92rem;
    color: #6b7c7a;
    max-width: 360px;
    line-height: 1.6;
}
</style>