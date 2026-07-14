<template>
  <AppLayout>
    <main class="stat-card-wrapper">

      <div class="side-bar-header">
        <p class="text-dark text-uppercase">Store Statistics</p>
      </div>
      <div class="row g-4 mb-4">
        <!-- Total Products -->
        <div class="col-md-6 col-xl-3">
          <div class="card border-0 shadow-sm h-100 stat-card">
            <div class="card-body d-flex align-items-center">
              <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                <i class="bi bi-box-seam"></i>
              </div>
              <div class="ms-3">
                <p class="text-muted mb-1 small">Total Products</p>
                <h4 class="mb-0 fw-bold">{{ totalProducts }}</h4>
              </div>
            </div>
          </div>
        </div>

        <!-- Active Products -->
        <div class="col-md-6 col-xl-3">
          <div class="card border-0 shadow-sm h-100 stat-card">
            <div class="card-body d-flex align-items-center">
              <div class="stat-icon bg-success bg-opacity-10 text-success">
                <i class="bi bi-check-circle"></i>
              </div>
              <div class="ms-3">
                <p class="text-muted mb-1 small">Active Products</p>
                <h4 class="mb-0 fw-bold">{{ activeProducts }}</h4>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Categories -->
        <div class="col-md-6 col-xl-3">
          <div class="card border-0 shadow-sm h-100 stat-card">
            <div class="card-body d-flex align-items-center">
              <div class="stat-icon bg-info bg-opacity-10 text-info">
                <i class="bi bi-grid-3x3-gap"></i>
              </div>
              <div class="ms-3">
                <p class="text-muted mb-1 small">Total Categories</p>
                <h4 class="mb-0 fw-bold">{{ totalCategories }}</h4>
              </div>
            </div>
          </div>
        </div>
        <!-- Income -->
        <div class="col-md-6 col-xl-3">
          <div class="card border-0 shadow-sm h-100 stat-card">
            <div class="card-body d-flex align-items-center">
              <div class="stat-icon bg-info bg-opacity-10 text-info">
                <i class="bi bi-currency-dollar"></i>
              </div>
              <div class="ms-3">
                <p class="text-muted mb-1 small">Total Income</p>
                <h5 class="mb-0 fw-bold">Rs {{ revenue }}</h5>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Customers -->
        <div class="col-md-6 col-xl-3">
          <div class="card border-0 shadow-sm h-100 stat-card">
            <div class="card-body d-flex align-items-center">
              <div class="stat-icon bg-purple bg-opacity-10 text-purple">
                <i class="bi bi-people"></i>
              </div>
              <div class="ms-3">
                <p class="text-muted mb-1 small">Total Customers</p>
                <h4 class="mb-0 fw-bold">{{ totalCustomers }}</h4>
              </div>
            </div>
          </div>
        </div>
        <!-- Orders -->
        <div class="col-md-6 col-xl-3">
          <div class="card border-0 shadow-sm h-100 stat-card">
            <div class="card-body d-flex align-items-center">
              <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                <i class="bi bi-cart3"></i>
              </div>
              <div class="ms-3">
                <p class="text-muted mb-1 small">Total Orders</p>
                <h4 class="mb-0 fw-bold">{{ totalOrders }}</h4>
              </div>
            </div>
          </div>
        </div>
        <!-- Pending Orders -->
        <div class="col-md-6 col-xl-3">
          <div class="card border-0 shadow-sm h-100 stat-card">
            <div class="card-body d-flex align-items-center">
              <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                <i class="bi bi-hourglass-split"></i>
              </div>
              <div class="ms-3">
                <p class="text-muted mb-1 small">Pending Orders</p>
                <h4 class="mb-0 fw-bold">{{ pendingOrders }}</h4>
              </div>
            </div>
          </div>
        </div>

        <!-- Cancelled Orders -->
        <div class="col-md-6 col-xl-3">
          <div class="card border-0 shadow-sm h-100 stat-card">
            <div class="card-body d-flex align-items-center">
              <div class="stat-icon bg-secondary bg-opacity-10 text-secondary">
                <i class="bi bi-x-circle"></i>
              </div>
              <div class="ms-3">
                <p class="text-muted mb-1 small">Cancelled Orders</p>
                <h4 class="mb-0 fw-bold">{{ cancelledOrders }}</h4>
              </div>
            </div>
          </div>
        </div>


      </div>
      <div class="side-bar-header">
        <p class="text-dark text-uppercase">Store Weekly Performance</p>
      </div>
      <div class="row g-4">
        <!-- Orders Chart -->
        <div class="col-md-6">
          <div class="card border-0 shadow-sm stat-card p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div>
                <p class="text-muted mb-0 small">Orders Overview</p>
                <h5 class="fw-semibold mb-0">Last 7 Days</h5>
              </div>
              <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                <i class="bi bi-cart3"></i>
              </div>
            </div>
            <div style="height: 300px;">
              <canvas ref="ordersChart"></canvas>
            </div>
          </div>
        </div>

        <!-- Income Chart -->
        <div class="col-md-6">
          <div class="card border-0 shadow-sm stat-card p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div>
                <p class="text-muted mb-0 small">Income Overview</p>
                <h5 class="fw-bold mb-0">Last 7 Days</h5>
              </div>
              <div class="stat-icon bg-success bg-opacity-10 text-success">
                <i class="bi bi-currency-dollar"></i>
              </div>
            </div>
            <div style="height: 300px;">
              <canvas ref="incomeChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </main>
  </AppLayout>
</template>

<script>

import axios from "axios";
import InputComponent from '@/Components/InputComponent.vue';
import AppLayout from '@/Layouts/SideNavBar.vue';
import {
  Chart,
  LineController,
  LineElement,
  PointElement,
  CategoryScale,
  LinearScale,
  Tooltip,
  Legend,
  Title,
} from "chart.js";

Chart.register(
  LineController,
  LineElement,
  PointElement,
  CategoryScale,
  LinearScale,
  Tooltip,
  Legend,
  Title
);



export default {
  components: {
    AppLayout,
    InputComponent
  },
  props: {
    totalProducts: Number,
    activeProducts: Number,
    totalCategories: Number,
    totalOrders: Number,
    totalCustomers: Number,
    pendingOrders: Number,
    cancelledOrders: Number,
    revenue:String,
    labels:Array,
    orders:Array,
    income:Array
  },
  data() {
    return {
      ordersChart: null,
      incomeChart: null,
      chartData: {
        labels: this.labels,
        orders: this.orders,
        income: this.income,
      },
    }
  },
  mounted() {
    this.renderOrdersChart();
    this.renderIncomeChart();
  },


  beforeUnmount() {
    if (this.ordersChart) this.ordersChart.destroy();
    if (this.incomeChart) this.incomeChart.destroy();
  },
  methods: {
    async fetchChartData() {
      try {
        const res = await axios.get("/api/dashboard/chart-stats");
        this.chartData = res.data;
        this.updateCharts();
      } catch (e) {
        console.error("Failed to load chart data", e);
      }
    },

    updateCharts() {
      this.ordersChart.data.labels = this.chartData.labels;
      this.ordersChart.data.datasets[0].data = this.chartData.orders;
      this.ordersChart.update();

      this.incomeChart.data.labels = this.chartData.labels;
      this.incomeChart.data.datasets[0].data = this.chartData.income;
      this.incomeChart.update();
    },

    renderOrdersChart() {
      const ctx = this.$refs.ordersChart.getContext("2d");
      const gradient = ctx.createLinearGradient(0, 0, 0, 300);
      gradient.addColorStop(0, "rgba(13,110,253,0.35)");
      gradient.addColorStop(1, "rgba(13,110,253,0)");

      this.ordersChart = new Chart(ctx, {
        type: "line",
        data: {
          labels: this.chartData.labels,
          datasets: [
            {
              label: "Orders",
              data: this.chartData.orders,
              borderColor: "#0d6efd",
              backgroundColor: gradient,
              pointBackgroundColor: "#0d6efd",
              pointBorderColor: "#fff",
              pointRadius: 4,
              pointHoverRadius: 6,
              tension: 0.4,
              fill: true,
              borderWidth: 2,
            },
          ],
        },
        options: this.chartOptions("Orders"),
      });
    },

    renderIncomeChart() {
      const ctx = this.$refs.incomeChart.getContext("2d");
      const gradient = ctx.createLinearGradient(0, 0, 0, 300);
      gradient.addColorStop(0, "rgba(25,135,84,0.35)");
      gradient.addColorStop(1, "rgba(25,135,84,0)");

      this.incomeChart = new Chart(ctx, {
        type: "line",
        data: {
          labels: this.chartData.labels,
          datasets: [
            {
              label: "Income ($)",
              data: this.chartData.income,
              borderColor: "#198754",
              backgroundColor: gradient,
              pointBackgroundColor: "#198754",
              pointBorderColor: "#fff",
              pointRadius: 4,
              pointHoverRadius: 6,
              tension: 0.4,
              fill: true,
              borderWidth: 2,
            },
          ],
        },
        options: this.chartOptions("Income"),
      });
    },

    chartOptions(label) {
      return {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          title: { display: false },
          tooltip: {
            backgroundColor: "#fff",
            titleColor: "#212529",
            bodyColor: "#212529",
            borderColor: "#dee2e6",
            borderWidth: 1,
            padding: 10,
            callbacks: {
              label: (ctx) =>
                label === "Income" ? ` $${ctx.parsed.y}` : ` ${ctx.parsed.y} orders`,
            },
          },
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: { color: "#f1f1f1" },
          },
          x: {
            grid: { display: false },
          },
        },
      };
    },
  },

}
</script>

<style></style>