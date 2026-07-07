<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'

const form = useForm({
  name: '',
  email: '',
  phone: '',
  address: '',
  password: '',
  password_confirmation: '',
})

const addressInput = ref(null)

onMounted(() => {
  if (!window.google) return

  const autocomplete = new google.maps.places.Autocomplete(addressInput.value, {
    types: ['address'],
  })

  autocomplete.addListener('place_changed', () => {
    const place = autocomplete.getPlace()
    form.address = place.formatted_address || place.name || ''
  })
})

function submit() {
  form.post('/register', {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <main class="auth-page">

    <Head title="Create account" />

    <div class="auth-card">
      <div class="auth-card-grid">

        <!-- Brand panel -->
        <section class="brand-panel">
          <div class="brand-top">
            <Link class="brand-name" :href="route('home')">
              <img src="/Images/resilimart-white.png" width="120">
            </Link>
          </div>

          <h1 class="brand-headline">
            Join thousands<br />
            <span class="grad-text px-2 fw-bold">shopping smarter</span><br />
            every single day
          </h1>

          <ul class="feature-list">
            <li class="feature-item">
              <span class="check-badge">
                <svg viewBox="0 0 16 16" class="check-icon">
                  <path d="M3 8.5L6.2 11.5L13 4.5" fill="none" stroke="currentColor" stroke-width="1.6"
                    stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
              <div>
                <p class="feature-title">Fast, Free Shipping</p>
                <p class="feature-sub">On every order over a set amount, no exceptions</p>
              </div>
            </li>
            <li class="feature-item">
              <span class="check-badge">
                <svg viewBox="0 0 16 16" class="check-icon">
                  <path d="M3 8.5L6.2 11.5L13 4.5" fill="none" stroke="currentColor" stroke-width="1.6"
                    stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
              <div>
                <p class="feature-title">Easy 30-Day Returns</p>
                <p class="feature-sub">Change your mind? Send it back, no questions asked</p>
              </div>
            </li>
            <li class="feature-item">
              <span class="check-badge">
                <svg viewBox="0 0 16 16" class="check-icon">
                  <path d="M3 8.5L6.2 11.5L13 4.5" fill="none" stroke="currentColor" stroke-width="1.6"
                    stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
              <div>
                <p class="feature-title">Exclusive Member Deals</p>
                <p class="feature-sub">Early access and discounts saved just for you</p>
              </div>
            </li>
          </ul>

          <p class="brand-footer">© 2026 ResiliMart. All rights reserved.</p>
        </section>

        <!-- Form panel -->
        <section class="form-panel">
          <div class="form-panel-inner">

            <p class="mobile-brand d-lg-none">ResiliMart</p>

            <h2 class="form-title">Create your account</h2>
            <p class="form-sub">Create your account to start shopping and track your orders.</p>

            <form @submit.prevent="submit" novalidate class="mt-4">

              <div class="field-group">
                <label for="name" class="field-label">Full name</label>
                <input id="name" type="text" v-model="form.name" class="field-input"
                  :class="{ 'is-invalid': form.errors.name }" placeholder="Jane Doe" autofocus autocomplete="name" />
                <div v-if="form.errors.name" class="field-error">
                  {{ form.errors.name }}
                </div>
              </div>

              <div class="field-group">
                <label for="email" class="field-label">Email address</label>
                <input id="email" type="email" v-model="form.email" class="field-input"
                  :class="{ 'is-invalid': form.errors.email }" placeholder="you@company.com" autocomplete="username" />
                <div v-if="form.errors.email" class="field-error">
                  {{ form.errors.email }}
                </div>
              </div>

              <div class="field-group">
                <label for="phone" class="field-label">Phone number</label>
                <input id="phone" type="text" v-model="form.phone" class="field-input"
                  :class="{ 'is-invalid': form.errors.phone }" placeholder="+94 71 234 5678" autocomplete="tel" />
                <div v-if="form.errors.phone" class="field-error">
                  {{ form.errors.phone }}
                </div>
              </div>

              <div class="field-group">
                <label for="address" class="field-label">Address</label>
                <input id="address" ref="addressInput" type="text" v-model="form.address" class="field-input"
                  :class="{ 'is-invalid': form.errors.address }" placeholder="Street, city, country"
                  autocomplete="off" />
                <div v-if="form.errors.address" class="field-error">
                  {{ form.errors.address }}
                </div>
              </div>

              <div class="field-row-split">
                <div class="field-group">
                  <label for="password" class="field-label">Password</label>
                  <input id="password" type="password" v-model="form.password" class="field-input"
                    :class="{ 'is-invalid': form.errors.password }" placeholder="••••••••"
                    autocomplete="new-password" />
                  <div v-if="form.errors.password" class="field-error">
                    {{ form.errors.password }}
                  </div>
                </div>

                <div class="field-group">
                  <label for="password_confirmation" class="field-label">Confirm</label>
                  <input id="password_confirmation" type="password" v-model="form.password_confirmation"
                    class="field-input" placeholder="••••••••" autocomplete="new-password" />
                </div>
              </div>

              <button type="submit" class="btn-primary-1 btn-primary" :disabled="form.processing">
                <span v-if="!form.processing" class="text-white">Create account</span>
                <span v-else class="text-white">Creating account…</span>
              </button>

            </form>

            <p class="switch-line">
              Already have an account?
              <Link :href="route('login.frontend')" class="link-quiet fw-semibold">Sign in</Link>
            </p>

          </div>
        </section>

      </div>
    </div>
  </main>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap');

.auth-page {
  --ink: #0b0f0e;
  --teal: #14b8a6;
  --teal-dark: #0d9488;
  --teal-soft: rgba(20, 184, 166, 0.14);
  --slate: #6b7280;
  --line: rgba(11, 15, 14, 0.1);
  --red: #d1453b;

  min-height: 100vh;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 40px 20px;
  background: linear-gradient(135deg, #eaf7f4 0%, #e9f1fb 60%, #eef4fb 100%);
  font-family: 'Inter', system-ui, sans-serif;
}

.auth-card {
  width: 100%;
  max-width: 1040px;
  background: #fff;
  border-radius: 28px;
  box-shadow: 0 30px 60px -20px rgba(11, 15, 14, 0.25);
  overflow: hidden;
}

.auth-card-grid {
  display: grid;
  grid-template-columns: 0.85fr 1.15fr;
  min-height: 640px;
}

/* ---------- Brand panel ---------- */

.brand-panel {
  background: linear-gradient(155deg, #123832 0%, #0c1f1c 55%, #090909 100%);
  color: #fff;
  padding: 40px 40px 32px;
  display: flex;
  flex-direction: column;
}

.brand-top {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 44px;
}

.brand-icon {
  width: 34px;
  height: 34px;
  border-radius: 9px;
  background: linear-gradient(135deg, var(--teal), #0a3a34);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Manrope', sans-serif;
  font-weight: 700;
  font-size: 12px;
  color: #fff;
  flex-shrink: 0;
}

.brand-name {
  font-family: 'Manrope', sans-serif;
  font-weight: 700;
  font-size: 15px;
  letter-spacing: 0.01em;
}

.brand-headline {
  font-family: 'Manrope', sans-serif;
  font-weight: 700;
  font-size: 27px;
  line-height: 1.3;
  letter-spacing: -0.01em;
  margin-bottom: 36px;
}

.grad-text {
  background: linear-gradient(90deg, var(--teal), #6ee7d8) !important;
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
}

.feature-list {
  list-style: none;
  padding: 0;
  margin: 0 0 auto;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.feature-item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
}

.check-badge {
  width: 22px;
  height: 22px;
  border-radius: 50%;
  background: #fff;
  color: var(--teal);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  margin-top: 1px;
}

.check-icon {
  width: 12px;
  height: 12px;
}

.feature-title {
  font-size: 13.5px;
  font-weight: 600;
  color: #fff;
  margin: 0;
}

.feature-sub {
  font-size: 12.5px;
  color: rgba(255, 255, 255, 0.5);
  margin: 2px 0 0;
}

.brand-footer {
  font-size: 11.5px;
  color: rgba(255, 255, 255, 0.35);
  margin-top: 40px;
}

/* ---------- Form panel ---------- */

.form-panel {
  background: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 40px;
}

.form-panel-inner {
  width: 100%;
  max-width: 420px;
}

.mobile-brand {
  display: none;
  font-family: 'Manrope', sans-serif;
  font-size: 19px;
  font-weight: 700;
  color: var(--ink);
  margin-bottom: 24px;
}

.form-title {
  font-family: 'Manrope', sans-serif;
  font-size: 24px;
  font-weight: 700;
  color: var(--ink);
  margin-bottom: 6px;
}

.form-sub {
  font-size: 13.5px;
  color: var(--slate);
  margin-bottom: 4px;
}

.field-group {
  margin-bottom: 18px;
  margin-top: 20px;
}

.field-row-split {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.field-row-split .field-group {
  margin-top: 20px;
}

.field-label {
  display: block;
  font-size: 12.5px;
  font-weight: 600;
  color: var(--ink);
  margin-bottom: 8px;
}

.field-input {
  width: 100%;
  border: 1.5px solid var(--line);
  border-radius: 10px;
  padding: 11px 14px;
  font-size: 14.5px;
  color: var(--ink);
  background: #fbfbfb;
  transition: border-color 0.15s, box-shadow 0.15s;
}

.field-input::placeholder {
  color: rgba(11, 15, 14, 0.32);
}

.field-input:focus {
  outline: none;
  border-color: var(--teal);
  background: #fff;
  box-shadow: 0 0 0 3px var(--teal-soft);
}

.field-input.is-invalid {
  border-color: var(--red);
}

.field-error {
  font-size: 12px;
  color: var(--red);
  margin-top: 6px;
}

.btn-primary-1 {
  width: 100%;
  color: #fff !important;
  border: none;
  border-radius: 10px;
  padding: 13px;
  font-size: 14px;
  font-weight: 600;
  transition: opacity 0.2s;
}

.btn-primary:hover:not(:disabled) {
  opacity: 0.9;
}

.btn-primary:focus-visible {
  outline: none;
  box-shadow: 0 0 0 3px var(--teal-soft);
}

.btn-primary:disabled {
  opacity: 0.55;
}

.link-quiet {
  font-size: 13px;
  color: var(--teal-dark);
  text-decoration: none;
  font-weight: 600;
}

.link-quiet:hover {
  text-decoration: underline;
}

.switch-line {
  margin-top: 22px;
  font-size: 13px;
  color: var(--slate);
  text-align: center;
}

/* ---------- Responsive ---------- */

@media (max-width: 900px) {
  .auth-card-grid {
    grid-template-columns: 1fr;
    min-height: auto;
  }

  .brand-panel {
    padding: 32px 28px;
  }

  .feature-list {
    margin-bottom: 24px;
  }

  .brand-headline {
    font-size: 22px;
    margin-bottom: 24px;
  }
}

@media (max-width: 600px) {
  .brand-panel {
    display: none;
  }

  .mobile-brand {
    display: block;
  }

  .form-panel {
    padding: 32px 24px;
  }

  .field-row-split {
    grid-template-columns: 1fr;
  }
}
</style>