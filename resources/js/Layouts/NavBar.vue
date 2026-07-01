<template>
    <main>
        <nav class="navbar navbar-expand-lg floating-nav mx-5 border rounded-4 mt-2" :class="{ 'has-entered': hasEntered, 'is-scrolled': isScrolled }">
            <div class="container-fluid px-lg-5">
                <Link class="navbar-brand">
                <div class="nav-bar-logo-wrapper">
                    <img src="/Images/resilimart-black.png" width="120" alt="">
                </div>
                </Link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item mx-1">
                            <Link class="nav-link px-3" :class="{ active: route().current('home') }"
                                :href="route('home')">Home</Link>
                        </li>
                        <li class="nav-item mx-1">
                            <Link class="nav-link px-3" :class="{ active: route().current('allproducts') }"
                                :href="route('allproducts')">All Products</Link>
                        </li>
                        <li class="nav-item mx-1">
                            <Link class="nav-link px-3" href="#">Categories</Link>
                        </li>
                        <li class="nav-item mx-1">
                            <Link class="nav-link px-3" :class="{ active: route().current('cart') }"
                                :href="route('cart')">Cart</Link>
                        </li>
                        <li class="nav-item mx-1">
                            <Link class="nav-link px-3" href="#">About Us</Link>
                        </li>
                    </ul>
                </div>
                <div class="">
                    <Link class="border p-2 rounded-circle position-relative mx-2" :href="route('cart')">
                    <i class="fa-solid fa-cart-flatbed text-black"></i>
                    <span
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-black text-white">
                        {{ totalItems }}
                    </span>
                    </Link>
                    <Link class="border p-2 rounded-circle mx-2" :href="route('profile.edit')">
                    <i class="fa-solid fa-user text-black"></i>
                    </Link>
                </div>

            </div>
        </nav>
    </main>
</template>

<script>
import { Link, usePage } from '@inertiajs/vue3';

export default {
    components: {
        Link
    },
    props: {
        totalItems: {
            type: Number,
            default: 0
        }
    },
      data() {
        return {
            isScrolled: false,
            hasEntered: false
        }
    },
    mounted() {
        window.addEventListener('scroll', this.handleScroll, { passive: true })
        // trigger the slide-down entrance animation shortly after mount
        requestAnimationFrame(() => {
            this.hasEntered = true
        })
    },
    unmounted() {
        window.removeEventListener('scroll', this.handleScroll)
    },
    methods: {
        handleScroll() {
            // subtle bg/shadow once page has scrolled a little — navbar itself never hides
            this.isScrolled = window.scrollY > 20
        }
    }
}
</script>

<style>
.floating-nav {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background: #ffffff;
    z-index: 1000;
    transform: translateY(0);
    transition: transform 0.35s ease, box-shadow 0.35s ease, background 0.35s ease;
}


.floating-nav.is-scrolled {
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.18);
}

.floating-nav.has-entered {
    transform: translateY(0);
}
</style>