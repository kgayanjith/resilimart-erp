<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const submit = () => {
  form.transform(data => ({
    ...data,
    remember: form.remember ? 'on' : '',
  })).post(route('login.frontend.post'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <main class="auth-page">
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
            Effortless<br />
            <span class="grad-text px-2 fw-bold">Online Shopping</span><br />
            Experience
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
                <p class="feature-title">Secure Checkout</p>
                <p class="feature-sub">Encrypted payments on every order, every time</p>
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
                <p class="feature-title">Real-time Order Tracking</p>
                <p class="feature-sub">Know exactly where your package is, always</p>
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
                <p class="feature-title">Member-only Rewards</p>
                <p class="feature-sub">Earn points and unlock exclusive offers</p>
              </div>
            </li>
          </ul>

          <p class="brand-footer">© 2026 ResiliMart. All rights reserved.</p>
        </section>

        <!-- Form panel -->
        <section class="form-panel">
          <div class="form-panel-inner">
            <h2 class="form-title">Welcome Back</h2>
            <p class="form-sub">Sign in to your account to continue</p>

            <form @submit.prevent="submit" novalidate class="mt-4">

              <div class="field-group">
                <label for="email" class="field-label">Email Address</label>
                <input id="email" type="email" v-model="form.email" class="field-input"
                  :class="{ 'is-invalid': form.errors.email }" placeholder="name@company.com" autofocus
                  autocomplete="username" />
                <div v-if="form.errors.email" class="field-error">
                  {{ form.errors.email }}
                </div>
              </div>

              <div class="field-group">
                <div class="label-row">
                  <label for="password" class="field-label">Password</label>
                  <Link href="/forgot-password" class="link-quiet">Forgot Password?</Link>
                </div>
                <div class="input-icon-wrap">
                  <input id="password" type="password" v-model="form.password" class="field-input"
                    :class="{ 'is-invalid': form.errors.password }" placeholder="••••••••"
                    autocomplete="current-password" />
                  <svg viewBox="0 0 24 24" class="eye-icon" aria-hidden="true">
                    <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" fill="none" stroke="currentColor"
                      stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <circle cx="12" cy="12" r="3" fill="none" stroke="currentColor" stroke-width="1.5" />
                  </svg>
                </div>
                <div v-if="form.errors.password" class="field-error">
                  {{ form.errors.password }}
                </div>
              </div>

              <label class="remember-check">
                <input type="checkbox" v-model="form.remember" class="remember-input" />
                <span class="remember-box"></span>
                <span class="remember-label">Keep me signed in</span>
              </label>

              <button type="submit" class="btn-primary btn-primary-1" :disabled="form.processing">
                <span v-if="!form.processing" class="text-white">Sign in</span>
                <span v-else class="text-white">Signing in…</span>
              </button>

              <div class="divider-row">
                <span class="divider-line"></span>
                <span class="divider-text">Or continue with SSO</span>
                <span class="divider-line"></span>
              </div>

              <div class="sso-row">
                <button type="button" class="btn-sso">
                  <svg viewBox="0 0 18 18" class="sso-icon">
                    <path fill="#4285F4"
                      d="M17.64 9.2c0-.64-.06-1.25-.16-1.84H9v3.48h4.84a4.14 4.14 0 0 1-1.8 2.72v2.26h2.9c1.7-1.57 2.7-3.88 2.7-6.62z" />
                    <path fill="#34A853"
                      d="M9 18c2.43 0 4.47-.8 5.96-2.18l-2.9-2.26c-.8.54-1.84.86-3.06.86-2.35 0-4.34-1.59-5.05-3.72H.98v2.33A9 9 0 0 0 9 18z" />
                    <path fill="#FBBC05"
                      d="M3.95 10.7A5.4 5.4 0 0 1 3.66 9c0-.59.1-1.16.29-1.7V4.97H.98A9 9 0 0 0 0 9c0 1.45.35 2.82.98 4.03l2.97-2.33z" />
                    <path fill="#EA4335"
                      d="M9 3.58c1.32 0 2.5.45 3.44 1.35l2.58-2.58C13.46.89 11.43 0 9 0A9 9 0 0 0 .98 4.97l2.97 2.33C4.66 5.17 6.65 3.58 9 3.58z" />
                  </svg>
                  Google
                </button>
                <button type="button" class="btn-sso">
                  <svg viewBox="0 0 18 18" class="sso-icon">
                    <rect x="0" y="0" width="8.5" height="8.5" fill="#F25022" />
                    <rect x="9.5" y="0" width="8.5" height="8.5" fill="#7FBA00" />
                    <rect x="0" y="9.5" width="8.5" height="8.5" fill="#00A4EF" />
                    <rect x="9.5" y="9.5" width="8.5" height="8.5" fill="#FFB900" />
                  </svg>
                  Microsoft
                </button>
              </div>

            </form>

            <p class="switch-line">
              Don't have an account?
              <Link :href="route('register.frontend')" class="link-quiet fw-semibold">Request an Account</Link>
            </p>
          </div>
        </section>

      </div>
    </div>
  </main>
</template>

<style scoped>

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
 
}

.auth-card {
  width: 100%;
  max-width: 960px;
  background: #fff;
  border-radius: 28px;
  box-shadow: 0 30px 60px -20px rgba(11, 15, 14, 0.25);
  overflow: hidden;
}

.auth-card-grid {
  display: grid;
  grid-template-columns: 0.9fr 1.1fr;
  min-height: 560px;
}

/* ---------- Brand panel ---------- */

.brand-panel {
background: linear-gradient(160deg, #0d3b38 0%, #0a2e2c 45%, #051312 100%);
  color: #fff;
  padding: 40px 40px 32px;
  display: flex;
  flex-direction: column;
}

.brand-top {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 48px;
}

.brand-icon {
  width: 30px;
  height: 30px;
  border-radius: 9px;
  /* background: linear-gradient(135deg, var(--teal), #0a3a34); */
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Manrope', sans-serif;
  font-weight: 700;
  font-size: 15px;
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
  font-size: 30px;
  line-height: 1.28;
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
  max-width: 360px;
}

.form-title {
  font-family: 'Manrope', sans-serif;
  font-size: 25px;
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
  margin-top: 22px;
}

.label-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 8px;
}

.label-row .field-label {
  margin-bottom: 0;
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

.input-icon-wrap {
  position: relative;
}

.input-icon-wrap .field-input {
  padding-right: 42px;
}

.eye-icon {
  position: absolute;
  right: 13px;
  top: 50%;
  transform: translateY(-50%);
  width: 18px;
  height: 18px;
  color: rgba(11, 15, 14, 0.35);
  pointer-events: none;
}

.remember-check {
  display: flex;
  align-items: center;
  gap: 9px;
  cursor: pointer;
  user-select: none;
  margin-bottom: 22px;
}

.remember-input {
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

.remember-box {
  width: 17px;
  height: 17px;
  border: 1.5px solid rgba(11, 15, 14, 0.25);
  border-radius: 5px;
  position: relative;
  flex-shrink: 0;
  transition: background 0.15s, border-color 0.15s;
}

.remember-input:checked+.remember-box {
  background: var(--teal-dark);
  border-color: var(--teal-dark);
}

.remember-input:checked+.remember-box::after {
  content: '';
  position: absolute;
  left: 4.5px;
  top: 1px;
  width: 4.5px;
  height: 8px;
  border: solid #fff;
  border-width: 0 1.5px 1.5px 0;
  transform: rotate(45deg);
}

.remember-input:focus-visible+.remember-box {
  box-shadow: 0 0 0 3px var(--teal-soft);
}

.remember-label {
  font-size: 13.5px;
  color: var(--slate);
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

.divider-row {
  display: flex;
  align-items: center;
  gap: 12px;
  margin: 22px 0;
}

.divider-line {
  flex: 1;
  height: 1px;
  background: var(--line);
}

.divider-text {
  font-size: 12px;
  color: var(--slate);
  white-space: nowrap;
}

.sso-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
}

.btn-sso {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  border: 1.5px solid var(--line);
  border-radius: 10px;
  background: #fff;
  padding: 10px;
  font-size: 13px;
  font-weight: 500;
  color: var(--ink);
  transition: background 0.15s, border-color 0.15s;
}

.btn-sso:hover {
  background: #fafafa;
  border-color: rgba(11, 15, 14, 0.2);
}

.sso-icon {
  width: 16px;
  height: 16px;
}

.link-quiet {
  font-size: 12.5px;
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

@media (max-width: 860px) {
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
    font-size: 24px;
    margin-bottom: 24px;
  }
}

@media (max-width: 500px) {
  .auth-page {
    padding: 0;
  }

  .auth-card {
    border-radius: 0;
    min-height: 100vh;
  }

  .form-panel {
    padding: 32px 24px;
  }
}
</style>