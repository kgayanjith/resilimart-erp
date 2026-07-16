<template>
    <AppLayout>
        <div class="mt-4 container-fluid px-lg-5 mb-5">
            <div>
                <h3 class="">All Products</h3>
            </div>
            <div class="row mt-5" v-if="allproducts && allproducts.length">
                <div class="col-12">
                    <div class="products-toolbar d-flex justify-content-between align-items-center mb-4">
                        <div class="results-count">
                            <span class="count-number">{{ allproducts.length }}</span>
                            <span class="count-label">products found</span>
                        </div>
                        <div class="sort-wrap">
                            <i class="fa-solid fa-arrow-down-wide-short sort-icon"></i>
                            <select class="sort-select" v-model="sortOption" @change="sortProducts">
                                <option value="">Sort by</option>
                                <option value="priceAsc">Price: Low to High</option>
                                <option value="priceDesc">Price: High to Low</option>
                                <option value="nameAsc">Name: A to Z</option>
                                <option value="nameDesc">Name: Z to A</option>
                            </select>
                            <i class="fa-solid fa-chevron-down chevron-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3" v-for="product in allproducts" :key="product.id">
                    <div class="product-wrapper">
                        <Link class="card rounded-4 p-1" href="/product">
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
            <div v-else class="empty-state text-center">
                <div class="empty-icon-wrap mx-auto mb-4">
                    <i class="fa-solid fa-box-open text-black"></i>
                </div>
                <h4 class="empty-title">No products yet</h4>
                <p class="empty-sub mx-auto">
                    We're still stocking this shelf. Check back soon, or explore other categories in the meantime.
                </p>
                <Link :href="route('home')" class="empty-cta mt-3">
                <i class="fa-solid fa-arrow-left me-2"></i>Back to home
                </Link>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { mapState, mapActions } from 'vuex';

export default {

    components: {
        AppLayout,
        Link
    },
    data() {
        return {
            sortOption: '',
            products: []
        };
    },
    props: {
        allproducts: Object
    },
    created() {
        // this.products = [...this.allproducts];
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
        // sortProducts() {
        //     switch (this.sortOption) {
        //         case 'priceAsc':
        //             this.products.sort((a, b) => a.price - b.price);
        //             break;
        //         case 'priceDesc':
        //             this.products.sort((a, b) => b.price - a.price);
        //             break;
        //         case 'nameAsc':
        //             this.products.sort((a, b) => a.name.localeCompare(b.name));
        //             break;
        //         case 'nameDesc':
        //             this.products.sort((a, b) => b.name.localeCompare(a.name));
        //             break;
        //         default:
        //             break;
        //     }
        // },
    }
}
</script>

<style></style>