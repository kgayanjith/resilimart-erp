<template>
  <AppLayout>
    <div class="mt-4">
      <HerosectionSlider :featuredproducts="featuredproducts" />
      <Categories :categories="categories" />
      <Latestproducts :latestproducts="latestproducts" />
      <Mostordered :mostorderedproducts="mostorderedproducts" />
      <Promotionbanner :banners="banners" />
      <Categorizedproducts :productsections="productsections" />
    </div>
   
  </AppLayout>

</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import HerosectionSlider from './partials/HerosectionSlider.vue';
import Categories from './partials/Categories.vue';
import Latestproducts from './partials/Latestproducts.vue';
import Mostordered from './partials/Mostordered.vue';
import Promotionbanner from './partials/Promotionbanner.vue';
import Categorizedproducts from './partials/Categorizedproducts.vue';


export default {
  inject: ['appLayout'],
  components: {
    AppLayout,
    HerosectionSlider,
    Categories,
    Latestproducts,
    Mostordered,
    Promotionbanner,
    Categorizedproducts
  },
  props: {
    banners: Object,
    categories: Object,
    latestproducts: Object,
    featuredproducts: Object,
    mostorderedproducts: Object,
    productsections: Object
  },
  
}
</script>

<style scoped>
* {
  font-family: "DM Sans", sans-serif;
}
</style>