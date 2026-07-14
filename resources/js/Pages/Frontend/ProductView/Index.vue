<template>
 <AppLayout>
    <main>
        <section class="container-fluid px-lg-5 mt-5">
            <ProductSlider :product="product" />
            <Recomendations :recommendedProducts="recommendedProducts" />
        </section>
    </main>
    
 </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import ProductSlider from './partials/ProductSlider.vue';
import Recomendations from './partials/Recomendations.vue';

export default {
    components: {
        AppLayout,
        ProductSlider,
        Recomendations

    },
    props:{
        product:Object,
        recommendedProducts:Array
    }
}
</script>

<style></style>