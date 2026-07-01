<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  name: '',
  email: '',
  phone: '',
  address: '',
  password: '',
  password_confirmation: '',
})

function submit() {
  form.post('/register', {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
 <main>
     <Head title="Create account" />

  <div class="auth-wrapper">
    <div class="row g-0 min-vh-100">

      <!-- Left panel — brand / black -->
      <div class="col-lg-5 d-none d-lg-flex brand-panel flex-column justify-content-between p-5">
        <div class="watermark">RM</div>

        <div class="position-relative">
          <p class="brand-mark mb-0">ResiliMart</p>
        </div>

        <div class="position-relative">
          <p class="quote mb-3">
            "The best time to spot a disruption is before it becomes
            an emergency. Set up your account and start watching."
          </p>
          <p class="quote-sub mb-0">Supply Chain Risk Intelligence</p>
        </div>
      </div>

      <!-- Right panel — form / white -->
      <div class="col-lg-7 d-flex align-items-center justify-content-center bg-white p-4 p-md-5">
        <div class="form-panel w-100">

          <p class="mobile-brand d-lg-none mb-4">ResiliMart</p>

          <h1 class="h3 fw-medium mb-2">Create your account</h1>
          <p class="text-muted-dark mb-4">Set up access to your dashboard and risk alerts.</p>

          <form @submit.prevent="submit" novalidate>

            <div class="mb-4">
              <label for="name" class="form-label label-sm">Full name</label>
              <input
                id="name"
                type="text"
                v-model="form.name"
                class="form-control form-control-mono"
                :class="{ 'is-invalid': form.errors.name }"
                placeholder="Jane Doe"
                autofocus
                autocomplete="name"
              />
              <div v-if="form.errors.name" class="invalid-feedback d-block">
                {{ form.errors.name }}
              </div>
            </div>

            <div class="mb-4">
              <label for="email" class="form-label label-sm">Email address</label>
              <input
                id="email"
                type="email"
                v-model="form.email"
                class="form-control form-control-mono"
                :class="{ 'is-invalid': form.errors.email }"
                placeholder="you@company.com"
                autocomplete="username"
              />
              <div v-if="form.errors.email" class="invalid-feedback d-block">
                {{ form.errors.email }}
              </div>
            </div>

            <div class="mb-4">
              <label for="phone" class="form-label label-sm">Phone number</label>
              <input
                id="phone"
                type="text"
                v-model="form.phone"
                class="form-control form-control-mono"
                :class="{ 'is-invalid': form.errors.phone }"
                placeholder="+94 71 234 5678"
                autocomplete="tel"
              />
              <div v-if="form.errors.phone" class="invalid-feedback d-block">
                {{ form.errors.phone }}
              </div>
            </div>

            <div class="mb-4">
              <label for="address" class="form-label label-sm">Address</label>
              <textarea
                id="address"
                v-model="form.address"
                class="form-control form-control-mono"
                :class="{ 'is-invalid': form.errors.address }"
                rows="2"
                placeholder="Street, city, country"
                autocomplete="street-address"
              ></textarea>
              <div v-if="form.errors.address" class="invalid-feedback d-block">
                {{ form.errors.address }}
              </div>
            </div>

            <div class="row">
              <div class="col-6 mb-4">
                <label for="password" class="form-label label-sm">Password</label>
                <input
                  id="password"
                  type="password"
                  v-model="form.password"
                  class="form-control form-control-mono"
                  :class="{ 'is-invalid': form.errors.password }"
                  placeholder="••••••••"
                  autocomplete="new-password"
                />
                <div v-if="form.errors.password" class="invalid-feedback d-block">
                  {{ form.errors.password }}
                </div>
              </div>

              <div class="col-6 mb-4">
                <label for="password_confirmation" class="form-label label-sm">Confirm</label>
                <input
                  id="password_confirmation"
                  type="password"
                  v-model="form.password_confirmation"
                  class="form-control form-control-mono"
                  placeholder="••••••••"
                  autocomplete="new-password"
                />
              </div>
            </div>

            <button
              type="submit"
              class="btn btn-mono w-100 mt-1"
              :disabled="form.processing"
            >
              {{ form.processing ? 'Creating account…' : 'Create account' }}
            </button>

          </form>

          <p class="mt-4 text-muted-dark small">
            Already have an account?
            <Link :href="route('login.frontend')" class="link-mono fw-semibold">Sign in</Link>
          </p>

        </div>
      </div>

    </div>
  </div>
 </main>
</template>

<style scoped>
/* Scoped to this page only — safe alongside Bootstrap and your other components */

.auth-wrapper {
  font-family: 'Inter', sans-serif;
}

.brand-panel {
  background: #0a0a0a;
  color: #ffffff;
  position: relative;
  overflow: hidden;
}

.watermark {
  position: absolute;
  left: -0.05em;
  bottom: -0.35em;
  font-weight: 300;
  font-size: 320px;
  line-height: 1;
  letter-spacing: -0.02em;
  color: transparent;
  -webkit-text-stroke: 1px rgba(255, 255, 255, 0.08);
  user-select: none;
  pointer-events: none;
}

.brand-mark {
  font-size: 22px;
  font-weight: 500;
  letter-spacing: -0.01em;
  position: relative;
  z-index: 1;
}

.quote {
  font-size: 20px;
  font-style: italic;
  line-height: 1.55;
  color: rgba(255, 255, 255, 0.92);
  max-width: 420px;
  position: relative;
  z-index: 1;
}

.quote-sub {
  font-size: 12px;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.42);
  position: relative;
  z-index: 1;
}

.mobile-brand {
  font-size: 20px;
  font-weight: 500;
  color: #0a0a0a;
}

.form-panel {
  max-width: 440px;
}

.text-muted-dark {
  color: rgba(10, 10, 10, 0.55);
}

.label-sm {
  font-size: 12px;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  font-weight: 600;
  color: rgba(10, 10, 10, 0.6);
  margin-bottom: 8px;
}

.form-control-mono {
  border: none;
  border-bottom: 1px solid rgba(10, 10, 10, 0.25);
  border-radius: 0;
  padding: 10px 2px;
  font-size: 15px;
  color: #0a0a0a;
  background: transparent;
  resize: none;
}

.form-control-mono:focus {
  border-bottom-color: #0a0a0a;
  box-shadow: none;
  background: transparent;
}

.form-control-mono.is-invalid {
  border-bottom-color: #0a0a0a;
}

.link-mono {
  font-size: 13px;
  color: rgba(10, 10, 10, 0.65);
  text-decoration: none;
  border-bottom: 1px solid transparent;
  transition: border-color 0.2s;
}
.link-mono:hover {
  color: #0a0a0a;
  border-bottom-color: #0a0a0a;
}

.btn-mono {
  background: #0a0a0a;
  color: #ffffff;
  border: 1px solid #0a0a0a;
  border-radius: 2px;
  padding: 12px;
  font-size: 13px;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  font-weight: 600;
  transition: opacity 0.2s;
}
.btn-mono:hover:not(:disabled) {
  opacity: 0.82;
  color: #ffffff;
}
.btn-mono:disabled {
  opacity: 0.5;
}

.invalid-feedback {
  font-size: 12.5px;
  color: #0a0a0a;
  margin-top: 4px;
}
</style>