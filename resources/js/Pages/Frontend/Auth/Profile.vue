<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, Link, useForm, usePage } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'

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

const addressInput = ref(null)

onMounted(() => {
  if (!window.google) return

  const autocomplete = new google.maps.places.Autocomplete(addressInput.value, {
    types: ['address'],
  })

  autocomplete.addListener('place_changed', () => {
    const place = autocomplete.getPlace()
    infoForm.address = place.formatted_address || place.name || ''
  })
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

function logout() {
  router.post(route('logout.frontend'), {}, {
    onSuccess: () => {
      // const modalEls = document.getElementById('logoutmodelprofile');
      // const modal = bootstrap.Modal.getInstance(modalEls);
      // modal?.hide();

      window.history.pushState(null, '', '/')
      window.onpopstate = function () {
        window.history.pushState(null, '', '/')
      }
    }
  })
}
</script>

<template>
  <AppLayout>
    <main class="profile-page">

      <Head title="My Profile" />

      <div class="container py-5">

        <!-- Header -->
        <div class="profile-header mb-4">
          <div class="avatar rounded-circle">{{ initials(customer.name) }}</div>
          <div>
            <div class="d-flex align-items-center gap-3 mb-1">
              <h1 class="profile-name mb-0">{{ customer.name }}</h1>
              <Link class="link-quiet" @click="logout()">Logout</Link>
            </div>
            <p class="profile-meta mb-0">
              Customer since {{ new Date(customer.created_at).toLocaleDateString('en-US', {
                month: 'long', year: 'numeric'
              }) }}
              <span class="status-dot" :class="customer.status ? 'active' : 'inactive'"></span>
              {{ customer.status ? 'Active' : 'Inactive' }}
            </p>
          </div>
        </div>

        <div class="row g-4">

          <!-- Personal info -->
          <div class="col-lg-7">
            <div class="panel-card border">
              <p class="section-title">Personal information</p>

              <form @submit.prevent="updateInfo">

                <div class="field-group">
                  <label class="field-label">Full name</label>
                  <input type="text" v-model="infoForm.name" class="field-input"
                    :class="{ 'is-invalid': infoForm.errors.name }" />
                  <div v-if="infoForm.errors.name" class="field-error">{{ infoForm.errors.name }}</div>
                </div>

                <div class="field-group">
                  <label class="field-label">Email address</label>
                  <input type="email" v-model="infoForm.email" class="field-input"
                    :class="{ 'is-invalid': infoForm.errors.email }" />
                  <div v-if="infoForm.errors.email" class="field-error">{{ infoForm.errors.email }}</div>
                </div>

                <div class="field-group">
                  <label class="field-label">Phone number</label>
                  <input type="text" v-model="infoForm.phone" class="field-input"
                    :class="{ 'is-invalid': infoForm.errors.phone }" />
                  <div v-if="infoForm.errors.phone" class="field-error">{{ infoForm.errors.phone }}</div>
                </div>

                <div class="field-group">
                  <label for="address" class="field-label">Address</label>
                  <input id="address" ref="addressInput" type="text" v-model="infoForm.address" class="field-input"
                    :class="{ 'is-invalid': infoForm.errors.address }" placeholder="Street, city, country"
                    autocomplete="off" />
                  <div v-if="infoForm.errors.address" class="field-error">
                    {{ infoForm.errors.address }}
                  </div>
                </div>

                <div class="d-flex align-items-center gap-3 mt-1">
                  <button type="submit" class="btn-primary btn-auto" :disabled="infoForm.processing">
                    {{ infoForm.processing ? 'Saving…' : 'Save changes' }}
                  </button>
                  <span v-if="infoForm.recentlySuccessful" class="saved-text">Saved.</span>
                </div>
              </form>
            </div>
          </div>

          <!-- Password -->
          <div class="col-lg-5">
            <div class="panel-card border">
              <p class="section-title">Change password</p>

              <form @submit.prevent="updatePassword">

                <div class="field-group">
                  <label class="field-label">Current password</label>
                  <input type="password" v-model="passwordForm.current_password" class="field-input"
                    :class="{ 'is-invalid': passwordForm.errors.current_password }" autocomplete="current-password" />
                  <div v-if="passwordForm.errors.current_password" class="field-error">
                    {{ passwordForm.errors.current_password }}
                  </div>
                </div>

                <div class="field-group">
                  <label class="field-label">New password</label>
                  <input type="password" v-model="passwordForm.password" class="field-input"
                    :class="{ 'is-invalid': passwordForm.errors.password }" autocomplete="new-password" />
                  <div v-if="passwordForm.errors.password" class="field-error">
                    {{ passwordForm.errors.password }}
                  </div>
                </div>

                <div class="field-group">
                  <label class="field-label">Confirm new password</label>
                  <input type="password" v-model="passwordForm.password_confirmation" class="field-input"
                    autocomplete="new-password" />
                </div>

                <div class="d-flex align-items-center gap-3 mt-1">
                  <button type="submit" class="btn-primary btn-auto" :disabled="passwordForm.processing">
                    {{ passwordForm.processing ? 'Updating…' : 'Update password' }}
                  </button>
                  <span v-if="passwordForm.recentlySuccessful" class="saved-text">Updated.</span>
                </div>
              </form>
            </div>
          </div>

        </div>

      </div>
       <!-- Modal -->
        <!-- <div class="modal fade" id="logoutmodelprofile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        Are you sure you want to logout?
                    </div>
                    <div class="modal-footer border-0 d-flex align-items-center justify-content-center">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary" @click="logout()">Yes</button>
                    </div>
                </div>
            </div>
        </div> -->
    </main>
  </AppLayout>
</template>

<style scoped>
.profile-page {
  --ink: #0b0f0e;
  --teal: #14b8a6;
  --teal-dark: #0d9488;
  --teal-soft: rgba(20, 184, 166, 0.14);
  --slate: #6b7280;
  --line: rgba(11, 15, 14, 0.1);
  --red: #d1453b;

  min-height: 100vh;
  width: 100%;

  font-family: 'Inter', sans-serif;
  color: var(--ink);
}



.profile-header {
  display: flex;
  align-items: center;
  gap: 20px;
}

.avatar {
  width: 60px;
  height: 60px;
  border-radius: 16px;
  background: #000;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Manrope', sans-serif;
  font-size: 17px;
  font-weight: 700;
  letter-spacing: 0.02em;
  flex-shrink: 0;
}

.profile-name {
  font-family: 'Manrope', sans-serif;
  font-size: 22px;
  font-weight: 700;
  color: var(--ink);
}

.profile-meta {
  font-size: 13.5px;
  color: var(--slate);
}

.status-dot {
  display: inline-block;
  width: 7px;
  height: 7px;
  border-radius: 50%;
  margin: 0 6px 0 10px;
}

.status-dot.active {
  background: var(--teal-dark);
}

.status-dot.inactive {
  background: rgba(11, 15, 14, 0.25);
}

.link-quiet {
  font-size: 13px;
  color: var(--teal-dark);
  text-decoration: none;
  font-weight: 600;
  cursor: pointer;
}

.link-quiet:hover {
  text-decoration: underline;
}

.panel-card {
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 20px 45px -25px rgba(11, 15, 14, 0.2);
  padding: 32px;
  height: 100%;
}

.section-title {
  font-size: 11px;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  font-weight: 700;
  color: var(--teal-dark);
  border-bottom: 1px solid var(--line);
  padding-bottom: 14px;
  margin-bottom: 24px;
}

/* ---------- Form fields ---------- */

.field-group {
  margin-bottom: 20px;
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
  resize: none;
  transition: border-color 0.15s, box-shadow 0.15s;
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

/* ---------- Buttons ---------- */

.btn-primary {
  color: #fff;
  border: none;
  border-radius: 10px;
  padding: 12px 24px;
  font-size: 13.5px;
  font-weight: 600;
  transition: opacity 0.2s;
}

.btn-auto {
  width: auto;
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

.saved-text {
  font-size: 13px;
  color: var(--teal-dark);
  font-weight: 500;
}

/* ---------- Responsive ---------- */

@media (max-width: 768px) {
  .panel-card {
    padding: 24px;
  }

  .profile-header {
    align-items: flex-start;
  }
}
</style>