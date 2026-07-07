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
              <p class="">
                <span class="bg-secondary py-1 px-3 rounded text-white section-title-2"><i class="fa-regular fa-truck"></i> Free Shipping Islandwide</span>
              </p>
               <div class="mt-4">
                <p class="mb-2 fw-bold">About the product</p>
                 <p class="card-text">{{ product.description }}</p>
               </div>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    components: {},
    props: {
        product: Array
    },
    data() {
        return {}
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
    height: 45
    0px !important;
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
</style>