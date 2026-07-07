<template>
    <main>
        <nav class="navbar navbar-expand-lg floating-nav mx-5 rounded-4 mt-2"
            :class="{ 'has-entered': hasEntered, 'is-scrolled': isScrolled }">
            <div class="container-fluid px-lg-5">
                <Link class="navbar-brand" :href="route('home')">
                <div class="nav-bar-logo-wrapper">
                    <img src="/Images/resilimart-black.png" width="120" alt="">
                </div>
                </Link>
                <button class="navbar-toggler toggler-mono" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0 nav-pill-group">
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
                            <Link class="nav-link px-3" :href="route('aboutus')" :class="{ active: route().current('aboutus') }">About Us</Link>
                        </li>
                    </ul>
                </div>
                <div class="d-flex align-items-center">
                    <div>
                        <Link class="cart-btn position-relative mx-2" :href="route('cart')">
                        <i class="fa-solid fa-cart-flatbed"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill cart-badge text-white"
                            v-if="totalItems > 0">
                            {{ totalItems }}
                        </span>
                        </Link>
                    </div>
                    <div class="mx-2">

                        <div class="dropdown" v-if="$page.props.customerAuth.user">
                            <div class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown"
                                aria-expanded="false" style="cursor: pointer;">
                                <div class="avatar-nav">{{ initials(name) }}</div>
                            </div>
                            <ul class="dropdown-menu dropdown-menu-end mt-3 border-0 p-2 shadow rounded-4 dropdown-mono">
                                <li class="dropdown-header">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-nav me-2">{{ initials(name) }}</div>
                                        <div>
                                            <div class="fw-bold dropdown-name">{{ $page.props.customerAuth.user.name }}
                                            </div>
                                            <small class="dropdown-email">{{ $page.props.customerAuth.user.email }}</small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <Link class="dropdown-item dropdown-item-mono" :href="route('profile.edit')">Profile</Link>
                                </li>
                                <li>
                                    <Link class="dropdown-item dropdown-item-mono">Orders</Link>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <button class="dropdown-item dropdown-item-mono text-danger" @click="logout()">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <Link class="account-btn" :href="route('login.frontend')" v-else>
                        <i class="fa-solid fa-user"></i>
                        </Link>
                    </div>
                </div>

            </div>
        </nav>
    </main>
</template>

<script>
import { Link, router, usePage } from '@inertiajs/vue3';
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
            hasEntered: false,
            name: this.$page.props.customerAuth?.user?.name ?? null
        }
    },
    mounted() {
        window.addEventListener('scroll', this.handleScroll, { passive: true })
        requestAnimationFrame(() => {
            this.hasEntered = true
        })
    },
    unmounted() {
        window.removeEventListener('scroll', this.handleScroll)
    },
    methods: {
        handleScroll() {
            this.isScrolled = window.scrollY > 20
        },
        logout() {
            router.post(route('logout.frontend'), {}, {
                onSuccess: () => {
                    window.history.pushState(null, '', '/')
                    window.onpopstate = function () {
                        window.history.pushState(null, '', '/')
                    }
                }
            })
        },
        initials(name) {
            return name
                .split(' ')
                .map((n) => n[0])
                .join('')
                .slice(0, 2)
                .toUpperCase()
        }
    }
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700&family=Inter:wght@400;500;600&display=swap');

.floating-nav {
    --ink: #0b0f0e;
    --teal: #14b8a6;
    --teal-dark: #0d9488;
    --teal-soft: rgba(20, 184, 166, 0.12);
    --slate: #6b7280;
    --line: rgba(11, 15, 14, 0.08);

    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border: 1px solid var(--line);
    z-index: 1000;
    transform: translateY(-140%);
    transition: transform 0.45s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.35s ease, background 0.35s ease;
    font-family: 'Inter', sans-serif;
}

.floating-nav.has-entered {
    transform: translateY(0);
}

.floating-nav.is-scrolled {
    box-shadow: 0 12px 32px -14px rgba(11, 15, 14, 0.22);
    background: rgba(255, 255, 255, 0.96);
}

.nav-bar-logo-wrapper {
    display: flex;
    align-items: center;
}

/* ---------- Nav links ---------- */

.nav-pill-group {
    gap: 2px;
}

.floating-nav .nav-link {
    font-size: 14px;
    font-weight: 500;
    color: var(--slate);
    border-radius: 999px;
    padding-top: 9px !important;
    padding-bottom: 9px !important;
    transition: color 0.15s, background 0.15s;
    position: relative;
}

.floating-nav .nav-link:hover {
    color: var(--ink);
    background: rgba(11, 15, 14, 0.04);
}

.floating-nav .nav-link.active {
    color: var(--teal-dark);
    background: var(--teal-soft);
    font-weight: 600;
}

/* ---------- Cart button ---------- */

.cart-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1.5px solid var(--line);
    color: var(--ink);
    background: #fff;
    transition: border-color 0.15s, color 0.15s;
}

.cart-btn:hover {
    border-color: var(--teal);
    color: var(--teal-dark);
}

.cart-badge {
    background: linear-gradient(135deg, var(--teal), var(--teal-dark));
    color: #fff;
    font-size: 10.5px;
    font-weight: 700;
    padding: 3px 6px;
}

/* ---------- Account / avatar ---------- */

.account-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1.5px solid var(--line);
    color: var(--ink);
    background: #fff;
    transition: border-color 0.15s, color 0.15s;
}

.account-btn:hover {
    border-color: var(--teal);
    color: var(--teal-dark);
}

.avatar-nav {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #000;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Manrope', sans-serif;
    font-size: 13.5px;
    font-weight: 700;
    letter-spacing: 0.02em;
    flex-shrink: 0;
}

/* ---------- Dropdown ---------- */

.dropdown-mono {
    min-width: 220px;
    background: #fff;
}

.dropdown-name {
    font-family: 'Manrope', sans-serif;
    font-size: 14px;
    color: var(--ink);
}

.dropdown-email {
    color: var(--slate);
    font-size: 12px;
}

.dropdown-item-mono {
    font-size: 13.5px;
    border-radius: 10px;
    padding: 9px 12px;
    transition: background 0.15s;
}

.dropdown-item-mono:hover {
    background: var(--teal-soft);
    color: var(--teal-dark);
}

/* ---------- Toggler ---------- */

.toggler-mono {
    border: 1.5px solid var(--line);
    padding: 6px 10px;
}

.toggler-mono:focus {
    box-shadow: 0 0 0 3px var(--teal-soft);
}
</style>