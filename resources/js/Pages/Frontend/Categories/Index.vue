<template>
    <AppLayout>
        <main class="container-fluid px-lg-5 mt-5">
            <div class="row">
                <div class="col-md-2 col-6 mb-4" v-for="category in categories" :key="category.id">
                    <button class="swiper-slide rounded-4 categorypage-wrapper border bg-white"
                        @click="categoryProduct(category.id)">
                        <div class="wrapper">
                            <div class="cimage-wrapper p-3">
                                <img :src="category.media[0]?.original_url" class="w-100 h-100" alt="">
                            </div>
                            <div class="category-name text-center">
                                <p class="text-black">{{ category.name }}</p>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </main>
    </AppLayout>

</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';


export default {
    components: {
        AppLayout,
        Link
    },
    props: {
        categories: Array
    },
    mounted() { },
    methods: {
        categoryProduct(id) {
            this.$inertia.visit(route('category.product', id));
            // console.log(id);
        }
    }
}
</script>

<style></style>