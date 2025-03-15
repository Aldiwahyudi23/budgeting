<template>
  <div>
    <canvas ref="expenseChart"></canvas>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { Chart, registerables } from 'chart.js';

// Props untuk menerima data dari parent
const props = defineProps({
  data: {
    type: Array,
    required: true,
  },
});

// Referensi ke elemen canvas
const expenseChart = ref(null);
let chartInstance = null;

// Buat atau perbarui grafik
const renderChart = () => {
  const ctx = expenseChart.value.getContext('2d');

  // Hapus grafik sebelumnya jika ada
  if (chartInstance) {
    chartInstance.destroy();
  }

  // Register semua komponen Chart.js
  Chart.register(...registerables);

  // Buat grafik baru
  chartInstance = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: props.data.map(item => item.category), // Label kategori
      datasets: [
        {
          label: 'Rencana',
          data: props.data.map(item => item.rencana), // Data rencana
          backgroundColor: 'rgba(54, 162, 235, 0.6)', // Warna biru
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1,
        },
        {
          label: 'Aktual',
          data: props.data.map(item => item.aktual), // Data aktual
          backgroundColor: 'rgba(75, 192, 192, 0.6)', // Warna hijau
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true, // Grafik responsif
      indexAxis: 'x', // Sumbu X horizontal
      scales: {
        x: {
          stacked: false, // Tidak stacked
        },
        y: {
          stacked: false, // Tidak stacked
          beginAtZero: true, // Mulai dari 0
          ticks: {
            callback: function (value) {
              return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
              }).format(value); // Format mata uang
            },
          },
        },
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: function (context) {
              const label = context.dataset.label || '';
              const value = context.raw || 0;
              return `${label}: ${new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
              }).format(value)}`; // Tooltip dengan format mata uang
            },
          },
        },
      },
    },
  });
};

// Render grafik saat komponen dimuat atau data berubah
onMounted(() => renderChart());
watch(() => props.data, () => renderChart());
</script>

<style scoped>
canvas {
  max-width: 100%;
  height: auto;
}
</style>