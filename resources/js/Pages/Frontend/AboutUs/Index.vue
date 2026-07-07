<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
</script>

<template>
    <AppLayout>
        <main class="about-page mt-4">

            <div class="container pb-5">

                <div class="hero-card mb-4 p-5">
                    <span class="badge-pill mb-4">Our Story</span>
                    <h1 class="slider-header-text mb-4">
                        Built on trust,<br />powered by care.
                    </h1>
                    <p class="hero-sub mb-4">
                        ResiliMart started with a simple idea everyday essentials should feel
                        considered, not disposable. We curate a small, careful selection instead
                        of an endless catalog, so every product on the shelf actually earns its place.
                    </p>


                    <div class="btn-browse-wrapper mt-3">
                        <Link class="btn-browse-main" :href="route('allproducts')">Browse Products</Link>
                        <Link class="btn-browse-arrow" :href="route('allproducts')">
                            <i class="fa-solid fa-arrow-right"></i>
                        </Link>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-lg-7">
                        <div class="story-card p-5 h-100 d-flex flex-column justify-content-center">
                            <span class="badge-pill-outline mb-3">How we started</span>
                            <h2 class="story-title mb-3">Small catalog. Fewer regrets.</h2>
                            <p class="story-text">
                                We got tired of scrolling through hundreds of near-identical listings
                                just to buy one good pair of headphones. So we flipped the model
                                our team tests, sources, and hand-picks every item before it ever
                                reaches the storefront. Fewer choices, better ones.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="story-card story-card-dark p-5 h-100 d-flex flex-column justify-content-center">
                            <span class="badge-pill-light text-white mb-3">Where we're headed</span>
                            <h2 class="story-title-light mb-3">Made to last, not to trend.</h2>
                            <p class="story-text-light">
                                As we grow, our filter stays the same: would we actually use this
                                ourselves? If not, it doesn't make the cut.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="stats-card mb-4 p-5">
                    <div class="row g-4 text-center text-lg-start">
                        <div class="col-6 col-lg-3">
                            <p class="stat-number">12k+</p>
                            <p class="stat-label">Happy customers</p>
                        </div>
                        <div class="col-6 col-lg-3">
                            <p class="stat-number">300+</p>
                            <p class="stat-label">Curated products</p>
                        </div>
                        <div class="col-6 col-lg-3">
                            <p class="stat-number">4.8<span class="stat-suffix">/5</span></p>
                            <p class="stat-label">Average rating</p>
                        </div>
                        <div class="col-6 col-lg-3">
                            <p class="stat-number">48h</p>
                            <p class="stat-label">Average delivery</p>
                        </div>
                    </div>
                </div>

                <p class="section-heading mb-4">What we stand for</p>
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="value-card p-4 h-100">
                            <span class="value-icon">
                                <i class="fa-solid fa-shield-halved"></i>
                            </span>
                            <h3 class="value-title">Quality first</h3>
                            <p class="value-text">Every product is tested and sourced before it's listed, not after
                                complaints roll in.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="value-card p-4 h-100">
                            <span class="value-icon">
                                <i class="fa-solid fa-truck-fast"></i>
                            </span>
                            <h3 class="value-title">Fast, honest delivery</h3>
                            <p class="value-text">Real tracking, real timelines. No surprise delays buried in fine
                                print.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="value-card p-4 h-100">
                            <span class="value-icon">
                                <i class="fa-solid fa-heart"></i>
                            </span>
                            <h3 class="value-title">People over sales</h3>
                            <p class="value-text">Support that actually helps, from people who use the products
                                themselves.</p>
                        </div>
                    </div>
                </div>

                <div
                    class="cta-card p-5 d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4">
                    <div>
                        <h2 class="cta-title mb-2">Ready to find something you'll actually keep?</h2>
                        <p class="cta-sub mb-0">Explore the full collection, curated piece by piece.</p>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                        <Link :href="route('allproducts')" class="btn-light-pill">Browse Products</Link>
                        <Link :href="route('allproducts')" class="btn-light-circle">
                            <i class="fa-solid fa-arrow-right"></i>
                        </Link>
                    </div>
                </div>

            </div>
        </main>
    </AppLayout>
</template>

<style scoped></style>