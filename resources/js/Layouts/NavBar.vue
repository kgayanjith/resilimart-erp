<template>
    <main>
        <nav class="navbar navbar-expand-lg sticky-top">
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
                            <Link class="nav-link px-3" href="#">FAQ</Link>
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
                        <Link class="border p-2 rounded-circle mx-2">
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
    }
}
</script>

<style></style>