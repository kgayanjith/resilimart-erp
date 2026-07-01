<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, Link, useForm, usePage } from '@inertiajs/vue3'

const page = usePage()
const customer = page.props.customerAuth.user

const infoForm = useForm({
  name: customer.name,
  email: customer.email,
  phone: customer.phone,
  address: customer.address,
})

const passwordForm = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
})

function updateInfo() {
  infoForm.patch('/profile', {
    preserveScroll: true,
  })
}

function updatePassword() {
  passwordForm.put('/profile/password', {
    preserveScroll: true,
    onSuccess: () => passwordForm.reset(),
    onError: () => {
      if (passwordForm.errors.password) passwordForm.reset('password', 'password_confirmation')
      if (passwordForm.errors.current_password) passwordForm.reset('current_password')
    },
  })
}

function initials(name) {
  return name
    .split(' ')
    .map((n) => n[0])
    .join('')
    .slice(0, 2)
    .toUpperCase()
}
</script>

<template>
    <AppLayout>
  <main>
    <Head title="My Profile" />

  <div class="profile-wrapper">

    <!-- Top bar -->


    <div class="container py-5">

      <!-- Header -->
      <div class="d-flex align-items-center gap-3 mb-5">
        <div class="avatar">{{ initials(customer.name) }}</div>
        <div>
          <h1 class="h4 fw-medium mb-1">{{ customer.name }}</h1>
          <p class="text-muted-dark small mb-0">
            Customer since {{ new Date(customer.created_at).toLocaleDateString('en-US', { month: 'long', year: 'numeric' }) }}
            <span class="status-dot" :class="customer.status ? 'active' : 'inactive'"></span>
            {{ customer.status ? 'Active' : 'Inactive' }}
          </p>
        </div>
      </div>

      <div class="row g-5">

        <!-- Personal info -->
        <div class="col-lg-7">
          <p class="section-title mb-4">Personal information</p>

          <form @submit.prevent="updateInfo">

            <div class="mb-4">
              <label class="form-label label-sm">Full name</label>
              <input
                type="text"
                v-model="infoForm.name"
                class="form-control form-control-mono"
                :class="{ 'is-invalid': infoForm.errors.name }"
              />
              <div v-if="infoForm.errors.name" class="invalid-feedback d-block">{{ infoForm.errors.name }}</div>
            </div>

            <div class="mb-4">
              <label class="form-label label-sm">Email address</label>
              <input
                type="email"
                v-model="infoForm.email"
                class="form-control form-control-mono"
                :class="{ 'is-invalid': infoForm.errors.email }"
              />
              <div v-if="infoForm.errors.email" class="invalid-feedback d-block">{{ infoForm.errors.email }}</div>
            </div>

            <div class="mb-4">
              <label class="form-label label-sm">Phone number</label>
              <input
                type="text"
                v-model="infoForm.phone"
                class="form-control form-control-mono"
                :class="{ 'is-invalid': infoForm.errors.phone }"
              />
              <div v-if="infoForm.errors.phone" class="invalid-feedback d-block">{{ infoForm.errors.phone }}</div>
            </div>

            <div class="mb-4">
              <label class="form-label label-sm">Address</label>
              <textarea
                v-model="infoForm.address"
                rows="2"
                class="form-control form-control-mono"
                :class="{ 'is-invalid': infoForm.errors.address }"
              ></textarea>
              <div v-if="infoForm.errors.address" class="invalid-feedback d-block">{{ infoForm.errors.address }}</div>
            </div>

            <div class="d-flex align-items-center gap-3">
              <button type="submit" class="btn btn-mono" :disabled="infoForm.processing">
                {{ infoForm.processing ? 'Saving…' : 'Save changes' }}
              </button>
              <span v-if="infoForm.recentlySuccessful" class="text-muted-dark small">Saved.</span>
            </div>
          </form>
        </div>

        <!-- Password -->
        <div class="col-lg-5">
          <p class="section-title mb-4">Change password</p>

          <form @submit.prevent="updatePassword">

            <div class="mb-4">
              <label class="form-label label-sm">Current password</label>
              <input
                type="password"
                v-model="passwordForm.current_password"
                class="form-control form-control-mono"
                :class="{ 'is-invalid': passwordForm.errors.current_password }"
                autocomplete="current-password"
              />
              <div v-if="passwordForm.errors.current_password" class="invalid-feedback d-block">
                {{ passwordForm.errors.current_password }}
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label label-sm">New password</label>
              <input
                type="password"
                v-model="passwordForm.password"
                class="form-control form-control-mono"
                :class="{ 'is-invalid': passwordForm.errors.password }"
                autocomplete="new-password"
              />
              <div v-if="passwordForm.errors.password" class="invalid-feedback d-block">
                {{ passwordForm.errors.password }}
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label label-sm">Confirm new password</label>
              <input
                type="password"
                v-model="passwordForm.password_confirmation"
                class="form-control form-control-mono"
                autocomplete="new-password"
              />
            </div>

            <div class="d-flex align-items-center gap-3">
              <button type="submit" class="btn btn-mono" :disabled="passwordForm.processing">
                {{ passwordForm.processing ? 'Updating…' : 'Update password' }}
              </button>
              <span v-if="passwordForm.recentlySuccessful" class="text-muted-dark small">Updated.</span>
            </div>
          </form>
        </div>

      </div>

    </div>
  </div>
  </main>
  </AppLayout>
</template>

<style scoped>
.profile-wrapper {
  font-family: 'Inter', sans-serif;
  min-height: 100vh;
  background: #ffffff;
  color: #0a0a0a;
}

.topbar {
  height: 72px;
  background: #0a0a0a;
  color: #ffffff;
}

.brand-mark {
  color: #ffffff;
  text-decoration: none;
  font-size: 18px;
  font-weight: 500;
}

.nav-link-mono {
  color: rgba(255, 255, 255, 0.6);
  text-decoration: none;
  font-size: 13.5px;
  background: none;
  border: none;
  padding: 0;
}
.nav-link-mono:hover {
  color: #ffffff;
}
.nav-link-mono.active {
  color: #ffffff;
  border-bottom: 1px solid #ffffff;
  padding-bottom: 4px;
}
.logout-btn {
  cursor: pointer;
}

.avatar {
  width: 56px;
  height: 56px;
  border-radius: 50%;
  background: #0a0a0a;
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  font-weight: 600;
  letter-spacing: 0.02em;
  flex-shrink: 0;
}

.text-muted-dark {
  color: rgba(10, 10, 10, 0.55);
}

.status-dot {
  display: inline-block;
  width: 7px;
  height: 7px;
  border-radius: 50%;
  margin: 0 6px 0 10px;
}
.status-dot.active {
  background: #0a0a0a;
}
.status-dot.inactive {
  background: rgba(10, 10, 10, 0.25);
}

.section-title {
  font-size: 11px;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  font-weight: 600;
  color: rgba(10, 10, 10, 0.42);
  border-bottom: 1px solid rgba(10, 10, 10, 0.1);
  padding-bottom: 14px;
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

.btn-mono {
  background: #0a0a0a;
  color: #ffffff;
  border: 1px solid #0a0a0a;
  border-radius: 2px;
  padding: 11px 24px;
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