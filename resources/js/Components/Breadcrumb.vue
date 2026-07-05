<template>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0 fw-bold">
      <li class="">
        <div href="/backend/dashboard" class="text-decoration-none">
          <i class="bi bi-house-door"></i> /
        </div>
      </li>
      <li>
        <div>
          <span class="px-1">{{ formattedPath }}</span>
        </div>
      </li>
    </ol>
  </nav>
</template>

<script>
export default {
  computed: {
    formattedPath() {
      const segments = this.$page.url
        .split("?")[0]
        .split("/")
        .filter(Boolean)
        .filter((s) => s !== "backend");

      return segments
        .map((s) => s.replace(/-/g, " ").replace(/\b\w/g, (c) => c.toUpperCase()))
        .join(" / ");
    },
  },
};
</script>

<style>
.breadcrumb-item span {
  font-weight: 700 !important;
}
</style>