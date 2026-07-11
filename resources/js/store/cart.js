import { createStore } from "vuex";

const loadCart = () => JSON.parse(sessionStorage.getItem("cart")) || [];
const saveCart = (cart) => sessionStorage.setItem("cart", JSON.stringify(cart));

const store = createStore({
    state: {
        cartItems: loadCart(),
        toast: false,
        toastMsg: "",
        cartDrawerOpen: false,
    },
    getters: {
        totalItems: (state) => state.cartItems.length,
        subTotal: (state) =>
            state.cartItems.reduce(
                (total, item) => total + item.price * item.quantity,
                0,
            ),
    },
    mutations: {
        SET_CART(state, cart) {
            state.cartItems = cart;
            saveCart(cart);
        },
        SHOW_TOAST(state, msg) {
            state.toastMsg = msg;
            state.toast = true;
        },
        HIDE_TOAST(state) {
            state.toast = false;
            state.toastMsg = "";
        },
        OPEN_CART_DRAWER(state) {
            state.cartDrawerOpen = true;
        },
        CLOSE_CART_DRAWER(state) {
            state.cartDrawerOpen = false;
        },
        CLEAR_CART(state) {
            state.cartItems = [];
            saveCart([]);
        },
    },
    actions: {
        addToCart({ state, commit }, product) {
            const cart = [...state.cartItems];
            const existing = cart.find((item) => item.id === product.id);

            if (existing) {
                existing.quantity++;
            } else {
                cart.push({
                    id: product.id,
                    name: product.name,
                    category: product.category.name,
                    description: product.description,
                    price: product.price,
                    image: product.media[0]?.original_url,
                    quantity: 1,
                });
            }

            commit("SET_CART", cart);
            commit("OPEN_CART_DRAWER");
        },

        increaseItem({ state, commit }, id) {
            const cart = [...state.cartItems];
            const item = cart.find((i) => i.id === id);
            if (item) {
                item.quantity++;
                commit("SET_CART", cart);
            }
        },

        decreaseItem({ state, commit, dispatch }, id) {
            const cart = [...state.cartItems];
            const item = cart.find((i) => i.id === id);
            if (!item) return;

            if (item.quantity > 1) {
                item.quantity--;
                commit("SET_CART", cart);
            } else {
                dispatch("removeItem", id);
            }
        },

        removeItem({ state, commit }, id) {
            const cart = state.cartItems.filter((i) => i.id !== id);
            commit("SET_CART", cart);
            commit("SHOW_TOAST", "Item removed from the cart");

            setTimeout(() => {
                commit("HIDE_TOAST");
            }, 2000);
        },

        clearCart({ commit }) {
            commit("SET_CART", []);
        },
    },
});

export default store;
