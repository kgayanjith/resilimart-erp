<template>
    <div class="container-fluid px-lg-5 mt-5">
        <div class="row row-wrapper justify-content-center">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="p-4 rounded rounded-4 left-column card h-100 border-0 shadow-0 text-center">
                    <h1 class="">Browse by Categories</h1>
                    <p>Explore collections designed to complement your lifestyle and express your individuality.</p>
                </div>
            </div>
        </div>
        <div class="category-slider">
            <div class="swiper mySwiper categorySlider" v-if="categories && categories.length">
                <div class="swiper-wrapper">
                    <div @click="categoryProductView(category.id)" class="swiper-slide rounded-4" v-for="category in categories" :key="category.id">
                    <div class="wrapper">
                        <div class="cimage-wrapper p-3">
                            <img :src="category.media[0]?.original_url" class="w-100 h-100" alt="" loading="lazy">
                        </div>
                        <div class="category-name text-center">
                            <p class="text-black">{{ category.name }}</p>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- <div class="swiper-pagination"></div> -->
                <!-- <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div> -->
            </div>
            <div v-else class="empty-categories text-center">
                <div class="empty-icon-wrap mx-auto mb-3">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <p class="empty-text mb-0">No categories to show yet.</p>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';


export default {
    data() {
        return {

        };
    },
    props: {
        categories: Object
    },
    components: {
        Link
    },
    mounted() {
        var swiper = new Swiper(".categorySlider", {
            slidesPerView: 7,
            spaceBetween: 10,
            // pagination: {
            //     el: ".swiper-pagination",
            //     clickable: true,
            // },
            // navigation: {
            //     nextEl: ".swiper-button-next",
            //     prevEl: ".swiper-button-prev",
            // },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            loop: true,
            breakpoints: {
                320: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                480: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 15,
                },
                992: {
                    slidesPerView: 5,
                    spaceBetween: 15,
                },
                1200: {
                    slidesPerView: 7,
                    spaceBetween: 10,
                },
            },
        });
    },
    methods:{
        categoryProductView(id) {
            this.$inertia.visit(route('category.product', id));
            // console.log(id);
        }
    }
}
</script>

<style scoped>
.empty-categories {
    padding: 2.5rem 1rem;
}

.empty-icon-wrap {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #e6f5f2;
    display: flex;
    align-items: center;
    justify-content: center;
}

.empty-icon-wrap i {
    font-size: 1.4rem;
    color: #0d9488;
}

.empty-text {
    font-size: 0.9rem;
    color: #6b7c7a;
}

</style>

<style>
.category-slider .swiper-pagination-bullet {
    width: 10px;
    height: 10px;
    background: #7e7e7e;
    opacity: 1;
    margin: 0 3px !important;
    position: relative;
}

.category-slider .swiper-pagination-bullet-active {
    width: 27px;
    border-radius: 18px;
    background: #000000;
}
</style>