<template>
  <main>
    <NavBar :total-items="totalItems" />
    <slot />
    <h1>Footer</h1>
    <button class="cart-fab" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-label="Open cart">
      <i class="fa-solid fa-bag-shopping"></i>
      <!-- <span v-if="totalItems > 0" class="cart-badge">{{ totalItems }}</span> -->
      <span v-if="cartItems.length !== 0"
        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark text-white">
        {{ totalItems }}
      </span>
    </button>
    <div class="offcanvas offcanvas-end" data-bs-backdrop="false" data-bs-scroll="true" tabindex="-1"
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
                Rs {{ item.price * item.quantity }}
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
            Subtotal: Rs {{ subTotal }}
          </span>
        </div>
        <button class="btn btn-dark w-100">Checkout</button>
      </div>
    </div>
    <!-- Toast -->
    <transition name="toast-slide">
      <div v-if="toast" class="toast-msg">{{ toast_msg }}</div>
    </transition>
  </main>
</template>

<script>
import NavBar from './NavBar.vue';


export default {
  components: {
    NavBar
  },
  provide() {
    return {
      appLayout: this,


    }
  },
  data() {
    return {
      cartItems: JSON.parse(sessionStorage.getItem('cart')) || [],
      toast: false,
      toast_msg: '',
      cartCount: JSON.parse(sessionStorage.getItem('cart')).length
    }
  },
  mounted() {


  },

  methods: {
    addToCart(product) {
      let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

      const existing = cart.find(item => item.id === product.id);

      if (existing) {
        existing.quantity++;
      } else {
        cart.push({
          id: product.id,
          name: product.name,
          price: product.price,
          image: product.media[0]?.original_url,
          quantity: 1
        });
      }

      sessionStorage.setItem('cart', JSON.stringify(cart));

      this.cartItems = cart;

      const offcanvas = new bootstrap.Offcanvas(
        document.getElementById('offcanvasRight')
      );

      offcanvas.show();
    },
    increase(id) {
      const item = this.cartItems.find(item => item.id === id);

      if (item) {
        item.quantity++;
        sessionStorage.setItem('cart', JSON.stringify(this.cartItems));
      }
    },

    decrease(id) {
      const item = this.cartItems.find(item => item.id === id);

      if (item) {
        if (item.quantity > 1) {
          item.quantity--;
        } else {
          this.removeItem(id);
          return;
        }

        sessionStorage.setItem('cart', JSON.stringify(this.cartItems));
      }
    },

    removeItem(id) {
      this.cartItems = this.cartItems.filter(item => item.id !== id);

      sessionStorage.setItem('cart', JSON.stringify(this.cartItems));
      this.toast_msg = 'Item removed from the cart'
      this.toast = true;
      setTimeout(() => {
        this.toast = false;
        this.toast_msg = ''
      }, 2000);
    },

  },
  computed: {
    totalItems() {
      return this.cartItems.length;
    },

    subTotal() {
      return this.cartItems.reduce((total, item) => {
        return total + (item.price * item.quantity);
      }, 0);
    }
  }

}
</script>

<style></style>