<script setup>
// Change import from Line to Bar
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Hero from "@/Components/Hero.vue";
import SalesStatistics from "@/Components/Dashboard/SalesStatistics.vue";
import { ref, watch, computed } from "vue";
import { router } from "@inertiajs/vue3";
import debounce from "lodash/debounce";
import { Bar } from "vue-chartjs";
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
} from "chart.js";

// Register ChartJS components
ChartJS.register(
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend
);

const props = defineProps({
    hero: String,
    statistics: Object,
    filters: Object,
    bestSellers: Array,
    lowStockProducts: Array,
    lowStockMaterials: Array,
});

// Initialize with default dates if not provided
const dateRange = ref({
    start: props.filters?.startDate || new Date().toISOString().substr(0, 10),
    end: props.filters?.endDate || new Date().toISOString().substr(0, 10),
});

// Helper function for currency formatting
const formatCurrency = (value) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(value);
};

// Watch for date range changes
watch(
    dateRange,
    () => {
        router.get(
            route("dashboard"),
            {
                startDate: dateRange.value.start,
                endDate: dateRange.value.end,
            },
            {
                preserveState: true,
                preserveScroll: true,
                only: ["statistics", "bestSellers"],
            }
        );
    },
    { deep: true }
);

// Add computed properties for chart data
// Update chart options for histogram style
const chartOptions = {
    responsive: true,
    scales: {
        y: {
            beginAtZero: true,
        },
    },
    plugins: {
        legend: {
            position: "top",
        },
    },
    barPercentage: 0.25, // Control bar width
    categoryPercentage: 1, // Control spacing between bars
};

const formatHour = (hour) => {
    if (!hour && hour !== 0) return "-";
    return `${hour.toString().padStart(2, "0")}:00`;
};

const salesChartData = computed(() => ({
    labels: props.statistics.dates || [],
    datasets: [
        {
            label: "Pendapatan Harian",
            data: props.statistics.daily_revenue || [],
            borderColor: "#4F46E5",
            backgroundColor: "#4F46E5",
            tension: 0.1,
        },
    ],
}));

const transactionChartData = computed(() => ({
    labels: props.statistics.dates || [],
    datasets: [
        {
            label: "Jumlah Transaksi",
            data: props.statistics.daily_transactions || [],
            borderColor: "#10B981",
            backgroundColor: "#10B981",
            tension: 0.1,
        },
    ],
}));

// Add new computed property for hourly chart data
const hourlyChartData = computed(() => ({
    labels: props.statistics.hours || [],
    datasets: [
        {
            label: "Transaksi per Jam",
            data: props.statistics.hourly_transactions || [],
            borderColor: "#8B5CF6",
            backgroundColor: "#8B5CF6",
            tension: 0.1,
        },
    ],
}));
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <Hero :heroTitle="hero" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Date Range Picker -->
                <div class="bg-white p-4 rounded-lg shadow mb-6">
                    <div class="flex gap-4 items-end">
                        <div class="flex-1">
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Tanggal Mulai
                            </label>
                            <input
                                type="date"
                                v-model="dateRange.start"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                        </div>

                        <div class="flex-1">
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Tanggal Akhir
                            </label>
                            <input
                                type="date"
                                v-model="dateRange.end"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                        </div>
                    </div>
                </div>

                <SalesStatistics :statistics="statistics" />

                <!-- Add after the existing statistics section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Revenue Chart -->
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">
                            Grafik Pendapatan
                        </h3>
                        <Bar :data="salesChartData" :options="chartOptions" />
                    </div>

                    <!-- Transaction Chart -->
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">
                            Grafik Transaksi
                        </h3>
                        <Bar
                            :data="transactionChartData"
                            :options="chartOptions"
                        />
                    </div>
                </div>

                <!-- Peak Hours Chart Section -->
                <div class="mt-6 bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">
                        Grafik Puncak Jam Penjualan
                    </h3>
                    <Bar :data="hourlyChartData" :options="chartOptions" />
                </div>

                <!-- Best Sellers Section -->
                <div
                    class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                >
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">
                        Produk Terlaris
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-sm font-medium text-gray-500"
                                    >
                                        Nama Produk
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-sm font-medium text-gray-500"
                                    >
                                        Tipe
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-sm font-medium text-gray-500"
                                    >
                                        Jumlah Terjual
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-sm font-medium text-gray-500"
                                    >
                                        Total Pendapatan
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr
                                    v-for="product in bestSellers"
                                    :key="product.id"
                                >
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ product.nama }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ product.tipe }}
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm text-right text-gray-900"
                                    >
                                        {{ product.total_terjual }}
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm text-right text-gray-900"
                                    >
                                        {{
                                            formatCurrency(
                                                product.total_pendapatan
                                            )
                                        }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Stock Monitoring Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Low Stock Products -->
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                    >
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">
                            Stok Produk Menipis
                        </h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-sm font-medium text-gray-500"
                                        >
                                            Nama Produk
                                        </th>
                                        <th
                                            class="px-6 py-3 text-right text-sm font-medium text-gray-500"
                                        >
                                            Stok
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr
                                        v-for="product in lowStockProducts"
                                        :key="product.id"
                                    >
                                        <td
                                            class="px-6 py-4 text-sm text-gray-900"
                                        >
                                            {{ product.nama }}
                                        </td>
                                        <td
                                            class="px-6 py-4 text-sm text-right text-red-600 font-semibold"
                                        >
                                            {{ product.stok }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Low Stock Materials -->
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                    >
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">
                            Stok Bahan Baku Menipis
                        </h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-sm font-medium text-gray-500"
                                        >
                                            Bahan Baku
                                        </th>
                                        <th
                                            class="px-6 py-3 text-center text-sm font-medium text-gray-500"
                                        >
                                            Stok
                                        </th>
                                        <th
                                            class="px-6 py-3 text-right text-sm font-medium text-gray-500"
                                        >
                                            Minimum
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr
                                        v-for="material in lowStockMaterials"
                                        :key="material.id"
                                    >
                                        <td
                                            class="px-6 py-4 text-sm text-gray-900"
                                        >
                                            {{ material.nama }}
                                        </td>
                                        <td
                                            class="px-6 py-4 text-sm text-center text-red-600 font-semibold"
                                        >
                                            {{ material.stok }}
                                            {{ material.satuan }}
                                        </td>
                                        <td
                                            class="px-6 py-4 text-sm text-right text-gray-500"
                                        >
                                            {{ material.minimum_stok }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
