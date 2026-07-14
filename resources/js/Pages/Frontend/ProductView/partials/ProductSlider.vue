<template>
    <main>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="slider-wrapper-product">
                    <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                        class="swiper mySwiper2">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide" v-for="img in product.media" :key="img.id">
                                <img :src="img.original_url" />
                            </div>

                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                    <div thumbsSlider="" class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide" v-for="img in product.media" :key="img.id">
                                <img :src="img.original_url" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <p class="section-title-2 mb-2">{{ product.category.name }}</p>
                <h1 class="comfortaa">{{ product.name }}</h1>
                <div class="mb-4 d-flex align-items-center">
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
                <div class="mb-3 d-flex align-items-center gap-4">
                    <h2 class="comfortaa">Rs {{ Number(product.price).toFixed(2) }}</h2>

                    <p class="mb-0"><i class="fa-solid fa-check"></i> 10 items sold</p>
                </div>
                <p class="stock-indicator mb-3">
                    <span class="stock-dot"></span> In Stock — Ready to Ship
                </p>
                <p class="">
                    <span class="bg-secondary py-1 px-3 rounded text-white section-title-2"><i
                            class="fa-regular fa-truck"></i> Free Shipping Islandwide</span>
                </p>
                <div class="mt-4">
                    <p class="mb-2 fw-bold">About the product</p>
                    <p class="card-text">{{ product.description }}</p>
                </div>
                <div class="d-flex gap-3 mt-4">
                    <div class="buy-bar w-100 mt-3">
                        <button @click.stop.prevent="addToCart(product)" :disabled="isInCart(product.id)"
                            class="buy-link w-100">
                            {{ isInCart(product.id) ? 'Already in Cart' : 'Add to Cart' }}
                        </button>
                    </div>
                    <div class="buy-bar w-100 mt-3 border" style="background-color:#f3f4f6 ">
                        <button class="btn btn-secondary buy-link btn-favorite w-100 border-0">
                            <i class="fa-regular fa-heart me-2"></i> Add to favorites
                        </button>
                    </div>
                </div>
                <div class="trust-badges d-flex gap-3 flex-wrap mt-5">
                    <div class="trust-badge">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Secure Checkout</span>
                    </div>
                    <div class="trust-badge">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>7-Day Returns</span>
                    </div>
                    <div class="trust-badge">
                        <i class="fa-solid fa-truck-fast"></i>
                        <span>Fast Delivery</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import { mapState, mapActions } from 'vuex';

export default {
    components: {},
    props: {
        product: Object
    },
    data() {
        return {}
    },
    computed: {
        ...mapState({
            cartItems: state => state.cartItems
        })
    },
    mounted() {
        // console.log(typeof this.product.price);

        var swiper = new Swiper('.mySwiper', {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });
        var swiper2 = new Swiper('.mySwiper2', {
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: swiper,
            },
        });
    },
    methods: {
        ...mapActions(['addToCart']),

        isInCart(productId) {
            return this.cartItems.some(item => item.id === productId);
        },
    }
}
</script>

<style scoped>
.swiper {
    width: 100%;
    height: 100%;
}

.swiper-slide {
    text-align: center;
    font-size: 18px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px solid rgb(188, 187, 187);
}

.swiper-slide img {
    display: block;
    width: 100% !important;
    height: 100% !important;
    object-fit: contain !important;
}

.swiper {
    width: 100% !important;
    height: 45 0px !important;
    margin-left: auto;
    margin-right: auto;
}

.swiper-slide {
    background-size: cover;
    background-position: center;
}

.mySwiper2 {
    /* height: 50% !important; */
    width: 100%;
}

.mySwiper {
    height: 100% !important;
    box-sizing: border-box;
    padding: 10px 0;
}

.mySwiper .swiper-slide {
    width: 25%;
    height: 100% !important;
    opacity: 0.4;
}

.mySwiper .swiper-slide-thumb-active {
    opacity: 1;
}

.swiper-slide img {
    /* display: block;
    width: 100%;
    height: 100% !important;
    object-fit: cover;
    padding: 5px; */
}

.section-title-2 {
    font-size: 13px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    font-weight: 700;
    padding-bottom: 14px;
    margin-bottom: 24px;
    color: gray;
}

.btn-add-cart {
    padding: 0.65rem 1rem;
    font-size: 0.9rem;
    font-weight: 600;
    color: #ffffff;
    background: #000000;
    border: none;
    border-radius: 10px;
    transition: opacity 0.15s ease;
}

.btn-add-cart:hover {
    opacity: 0.85;
}

.btn-favorite {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: #6b7280;
    background: #f3f4f6;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    flex-shrink: 0;
    transition: background 0.15s ease, color 0.15s ease;
}

.btn-favorite:hover {
    background: #e5e7eb;
}

.btn-favorite.active {
    color: #dc2626;
    background: #fef2f2;
    border-color: #fecaca;
}

.whitelist {
    background: #ffffff;

}

.trust-badge {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.8rem;
    font-weight: 500;
    color: #4b615e;
    background: #f6f9f8;
    border: 1px solid #e6edec;
    padding: 0.45rem 0.85rem;
    border-radius: 999px;
}

.trust-badge i {
    color: #0d9488;
    font-size: 0.85rem;
}
.stock-indicator {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.85rem;
    font-weight: 600;
    color: #16a34a;
}

.stock-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #16a34a;
}
</style>