<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';



defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('backend.login.post'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>

    <div class="admin-login d-flex">
        <!-- Brand panel -->
        <div class="brand-panel d-none d-lg-flex flex-column justify-content-between">
            <svg class="route-lines" viewBox="0 0 600 800" preserveAspectRatio="xMidYMid slice">
                <path d="M40,120 C160,60 220,220 340,180 S480,60 560,140" class="route" style="animation-delay:0s" />
                <path d="M20,340 C140,300 200,420 320,380 S460,300 580,360" class="route" style="animation-delay:1.2s" />
                <path d="M0,560 C120,500 200,620 300,580 S460,520 600,600" class="route" style="animation-delay:2.4s" />
                <path d="M60,700 C180,660 240,760 360,720 S500,680 590,740" class="route" style="animation-delay:0.6s" />
                <circle cx="40" cy="120" r="4" class="node" style="animation-delay:0s" />
                <circle cx="340" cy="180" r="4" class="node" style="animation-delay:0.4s" />
                <circle cx="560" cy="140" r="4" class="node" style="animation-delay:0.8s" />
                <circle cx="320" cy="380" r="4" class="node" style="animation-delay:1.2s" />
                <circle cx="580" cy="360" r="4" class="node" style="animation-delay:1.6s" />
                <circle cx="300" cy="580" r="4" class="node" style="animation-delay:2s" />
                <circle cx="360" cy="720" r="4" class="node" style="animation-delay:2.4s" />
            </svg>

            <div class="brand-top">
                <img src="/Images/resilimart-white.png" class="brand-logo" width="150" alt="resilimart-logo">
            </div>

            <div class="brand-copy">
                <p class="brand-eyebrow">Admin console</p>
                <h1 class="brand-heading">Supply chain visibility,<br>one dashboard away.</h1>
                <p class="brand-sub">Monitor suppliers, shipping routes, and risk signals in real time.</p>
            </div>

            <p class="brand-footer">&copy; {{ new Date().getFullYear() }} ResiliMart. All rights reserved.</p>
        </div>

        <!-- Form panel -->
        <div class="form-panel d-flex flex-column justify-content-center align-items-center flex-grow-1">
            <div class="login-card">
                <div class="d-lg-none text-center mb-4">
                    <img src="/Images/resilimart-black.png" width="150" alt="resilimart-logo">
                </div>

                <p class="eyebrow">Welcome back</p>
                <h2 class="title mb-1">Sign in to your dashboard</h2>
                <p class="subtitle mb-4">Enter your admin credentials to continue.</p>

                <div v-if="status" class="alert-status mb-3">{{ status }}</div>

                <form @submit.prevent="submit" class="login-form" novalidate>
                    <div class="mb-3">
                        <label for="email" class="field-label">Email</label>
                        <div class="input-wrap">
                            <i class="input-icon bi-envelope"></i>
                            <input type="email" class="field-input" id="email" v-model="form.email"
                                placeholder="you@resilimart.com" autofocus autocomplete="username" required>
                        </div>
                        <InputError class="mt-1" :message="form.errors.email" />
                    </div>

                    <div class="mb-3">
                        <label for="password" class="field-label">Password</label>
                        <div class="input-wrap">
                            <i class="input-icon bi-lock"></i>
                            <input type="password" class="field-input" id="password" v-model="form.password"
                                placeholder="Enter your password" autocomplete="current-password" required>
                        </div>
                        <InputError class="mt-1" :message="form.errors.password" />
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <label class="remember-label d-flex align-items-center mb-0">
                            <Checkbox v-model:checked="form.remember" name="remember" />
                            <span class="ms-2">Remember me</span>
                        </label>

                        <!-- <Link v-if="canResetPassword" :href="route('password.request')" class="forgot-link">
                            Forgot password?
                        </Link> -->
                    </div>

                    <button class="btn-submit w-100" type="submit" :disabled="form.processing">
                        <span v-if="!form.processing" class="text-white">Sign in</span>
                        <span v-else class="text-white">Signing in&hellip;</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap');

.admin-login {
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
    background: #f4f7f7;
}

/* Brand panel */
.brand-panel {
    position: relative;
    width: 42%;
    max-width: 520px;
    padding: 3rem 3.5rem;
    background: linear-gradient(160deg, #0d3b38 0%, #0a2e2c 45%, #051312 100%);
    overflow: hidden;
}

.route-lines {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0.5;
}

.route {
    fill: none;
    stroke: #14b8a6;
    stroke-width: 1.4;
    stroke-linecap: round;
    stroke-dasharray: 6 10;
    animation: dash 8s linear infinite;
    opacity: 0.55;
}

.node {
    fill: #5eead4;
    animation: pulse 3s ease-in-out infinite;
}

@keyframes dash {
    to { stroke-dashoffset: -160; }
}

@keyframes pulse {
    0%, 100% { opacity: 0.3; r: 3; }
    50% { opacity: 0.9; r: 5; }
}

.brand-top,
.brand-copy,
.brand-footer {
    position: relative;
    z-index: 1;
}

.brand-logo {
 
}

.brand-eyebrow {
    font-family: 'Manrope', sans-serif;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #5eead4;
    margin-bottom: 0.75rem;
}

.brand-heading {
    font-family: 'Manrope', sans-serif;
    font-size: 2rem;
    font-weight: 700;
    line-height: 1.25;
    color: #ffffff;
    margin-bottom: 0.9rem;
}

.brand-sub {
    font-size: 0.95rem;
    color: rgba(255, 255, 255, 0.65);
    max-width: 320px;
    line-height: 1.6;
}

.brand-footer {
    font-size: 0.78rem;
    color: rgba(255, 255, 255, 0.4);
}

/* Form panel */
.form-panel {
    flex: 1;
    padding: 2rem;
}

.login-card {
    width: 100%;
    max-width: 400px;
    background: #ffffff;
    border-radius: 20px;
    padding: 2.75rem 2.5rem;
    box-shadow: 0 20px 50px -12px rgba(5, 19, 18, 0.12);
}

.eyebrow {
    font-family: 'Manrope', sans-serif;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #0d9488;
    margin-bottom: 0.5rem;
}

.title {
    font-family: 'Manrope', sans-serif;
    font-size: 1.5rem;
    font-weight: 700;
    color: #0f2b29;
}

.subtitle {
    font-size: 0.9rem;
    color: #6b7c7a;
}

.alert-status {
    font-size: 0.85rem;
    color: #0d9488;
    background: #e6fbf7;
    border: 1px solid #99f0e2;
    border-radius: 10px;
    padding: 0.65rem 0.9rem;
}

.field-label {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    color: #274b47;
    margin-bottom: 0.4rem;
}

.input-wrap {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 0.9rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9db3b0;
    font-size: 0.95rem;
    pointer-events: none;
}

.field-input {
    width: 100%;
    padding: 0.7rem 0.9rem 0.7rem 2.5rem;
    font-size: 0.92rem;
    color: #14332f;
    background: #f6f9f8;
    border: 1.5px solid #e3ebea;
    border-radius: 10px;
    transition: border-color 0.15s ease, background 0.15s ease;
}

.field-input:focus {
    outline: none;
    border-color: #14b8a6;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.12);
}

.field-input::placeholder {
    color: #a9bab8;
}

.remember-label {
    font-size: 0.85rem;
    color: #4b615e;
    cursor: pointer;
}

.forgot-link {
    font-size: 0.85rem;
    color: #0d9488;
    text-decoration: none;
    font-weight: 500;
}

.forgot-link:hover {
    text-decoration: underline;
}

.btn-submit {
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    font-weight: 600;
    color: #ffffff;
    background: #000;
    border: none;
    border-radius: 10px;
    transition: transform 0.12s ease, box-shadow 0.12s ease, opacity 0.12s ease;
    box-shadow: 0 8px 20px -6px rgba(13, 148, 136, 0.45);
}

.btn-submit:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 10px 24px -6px rgba(13, 148, 136, 0.55);
}

.btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

@media (max-width: 991.98px) {
    .form-panel {
        padding: 2rem 1.25rem;
    }

    .login-card {
        box-shadow: 0 12px 30px -10px rgba(5, 19, 18, 0.12);
        padding: 2.25rem 1.75rem;
    }
}
</style>