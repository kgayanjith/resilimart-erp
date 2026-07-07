<template>
  <main>
    <NavBar :total-items="totalItems" />
   <div class="mt-5 pt-4">
     <slot />
   </div>
    <Footer />
  <button class="fab-cart" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-label="Open cart">
  <i class="fa-solid fa-bag-shopping fab-cart-icon"></i>
  <span v-if="cartItems.length !== 0" class="fab-cart-badge text-white">
    {{ totalItems }}
  </span>
</button>
    <div class="offcanvas offcanvas-end" data-bs-backdrop="true" data-bs-scroll="true" tabindex="-1"
      id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
      <button type="button" class="btn-close m-2" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      <div class="offcanvas-body position-relative">
        <div v-if="cartItems.length !== 0">
          <div v-for="item in cartItems" :key="item.id" style="display:flex; align-items:center; gap:12px; padding:12px;
           background:#fff; border:0.5px solid #e5e7eb;
           border-radius:10px; margin-bottom:10px;">
            <img :src="item.image" width="60" height="60" style="border-radius:8px; object-fit:cover; flex-shrink:0;">
            <div style="flex:1; min-width:0;">
              <p style="margin:0 0 4px; font-size:14px; font-weight:500;
                white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                {{ item.name }}
              </p>
              <div style="display:flex; align-items:center; gap:6px;">
                <button @click="decrease(item.id)" style="width:28px; height:28px; border:1px solid #d1d5db;
                 border-radius:6px; background:#f9fafb; cursor:pointer;
                 font-size:16px; display:flex; align-items:center; justify-content:center;">
                  −
                </button>
                <span style="min-width:24px; text-align:center; font-size:14px; font-weight:500;">
                  {{ item.quantity }}
                </span>
                <button @click="increase(item.id)" style="width:28px; height:28px; border:1px solid #d1d5db;
                 border-radius:6px; background:#f9fafb; cursor:pointer;
                 font-size:16px; display:flex; align-items:center; justify-content:center;">
                  +
                </button>
              </div>
            </div>
            <div style=" display:flex; flex-direction:column; align-items:flex-end; gap:8px; flex-shrink:0;">
              <span style="font-size:14px; font-weight:500;">
                Rs {{ (item.price * item.quantity).toFixed(2) }}
              </span>
              <button @click="removeItem(item.id)" class="btn btn-sm" style="width:28px; height:28px; border:1px solid #fca5a5;
               border-radius:6px; color:#ef4444; background:transparent;
               display:flex; align-items:center; justify-content:center; cursor:pointer;">
                ✕
              </button>
            </div>
          </div>
        </div>
        <div v-else>
          <div class="cart-notify">
            <p>No Products added to the cart</p>
          </div>
        </div>
      </div>
      <div style="position:sticky; bottom:0; border-top:1px solid #e5e7eb; padding:14px 16px; background:#fff;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
          <span style="font-size:13px; color:#6b7280;">
            Items: <strong style="color:#111827;">{{ totalItems }}</strong>
          </span>
          <span style="font-size:15px; font-weight:500;">
            Subtotal: Rs {{ subTotal.toFixed(2) }}
          </span>
        </div>
        <button class="btn btn-dark w-100">Checkout</button>
      </div>
    </div>
    <transition name="toast-slide">
      <div v-if="toast" class="toast-msg">{{ toastMsg }}</div>
    </transition>
  </main>
</template>

<script>
import Footer from './Footer.vue';
import NavBar from './NavBar.vue'
import { mapState, mapGetters, mapActions } from 'vuex'

export default {
  components: {
    NavBar,
    Footer
  },
  provide() {
    return {
      appLayout: this
    }
  },
  computed: {
    ...mapState({
      cartItems: (state) => state.cartItems,
      toast: (state) => state.toast,
      toastMsg: (state) => state.toastMsg,
      cartDrawerOpen: (state) => state.cartDrawerOpen
    }),
    ...mapGetters(['totalItems', 'subTotal'])
  },
  watch: {
    cartDrawerOpen(isOpen) {
      if (isOpen) {
        const el = document.getElementById('offcanvasRight')
        const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(el)
        offcanvas.show()
        this.$store.commit('CLOSE_CART_DRAWER')
      }
    }
  },
  methods: {
    ...mapActions(['removeItem']),

    addToCart(product) {
      this.$store.dispatch('addToCart', product)
    },
    increase(id) {
      this.$store.dispatch('increaseItem', id)
    },
    decrease(id) {
      this.$store.dispatch('decreaseItem', id)
    }
  }
}
</script>

<style></style>