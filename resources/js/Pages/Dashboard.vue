<script setup>
import Hero from "@/Components/Hero.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { onMounted } from "vue";
import Chart from "chart.js/auto";

const props = defineProps({
    hero: String,
    statistics: {
        type: Object,
        required: true,
    },
});

onMounted(() => {
    // Today's Sales and Purchases Chart
    const ctx = document.getElementById("todayChart").getContext("2d");

    // Prepare data
    const hours = Array.from({ length: 24 }, (_, i) => i);
    const salesData = new Array(24).fill(0);
    const purchasesData = new Array(24).fill(0);

    // Fill in sales data
    props.statistics.todayData.sales.forEach((item) => {
        salesData[item.hour] = item.total;
    });

    // Fill in purchases data
    props.statistics.todayData.purchases.forEach((item) => {
        purchasesData[item.hour] = item.total;
    });

    new Chart(ctx, {
        type: "line",
        data: {
            labels: hours.map((hour) => `${hour}:00`),
            datasets: [
                {
                    label: "Penjualan",
                    data: salesData,
                    borderColor: "rgb(59, 130, 246)",
                    backgroundColor: "rgba(59, 130, 246, 0.1)",
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: "Pembelian",
                    data: purchasesData,
                    borderColor: "rgb(239, 68, 68)",
                    backgroundColor: "rgba(239, 68, 68, 0.1)",
                    fill: true,
                    tension: 0.4,
                },
            ],
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: (value) => "Rp " + value.toLocaleString(),
                    },
                },
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            const label = context.dataset.label || "";
                            const value = context.parsed.y;
                            return `${label}: Rp ${value.toLocaleString()}`;
                        },
                    },
                },
            },
        },
    });

    // Weekly sales chart
    const weeklyCtx = document.getElementById("weeklyChart");
    new Chart(weeklyCtx, {
        type: "line",
        data: {
            labels: props.statistics.salesData.map((item) =>
                new Date(item.date).toLocaleDateString("id-ID", {
                    weekday: "short",
                })
            ),
            datasets: [
                {
                    label: "Penjualan",
                    data: props.statistics.salesData.map(
                        (item) => item.total_sales
                    ),
                    borderColor: "#648374",
                    tension: 0.3,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: (value) => `Rp${value.toLocaleString()}`,
                    },
                },
            },
        },
    });
});
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <Hero :heroTitle="hero" />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Today's Statistics and Low Stock Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Today's Sales Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold mb-4">
                            Penjualan & Pembelian Hari Ini
                        </h2>
                        <p class="text-3xl font-bold">
                            Rp
                            {{
                                props.statistics.totalPenjualanHariIni.toLocaleString()
                            }}
                        </p>
                        <p class="text-gray-600">
                            {{ props.statistics.totalTransaksiHariIni }}
                            Transaksi
                        </p>
                        <canvas id="todayChart" height="200"></canvas>
                    </div>

                    <!-- Low Stock Warnings -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold mb-4">Stok Menipis</h2>
                        <div
                            class="overflow-y-auto max-h-[475px] scrollbar-thin"
                        >
                            <div class="space-y-2">
                                <div
                                    v-for="product in props.statistics
                                        .productLowStock"
                                    :key="product.id"
                                    class="p-2 hover:bg-gray-50 rounded"
                                >
                                    <p class="text-red-600">
                                        {{ product.nama }} ({{ product.stok }}
                                        tersisa)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Weekly Sales Chart -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">
                        Penjualan 7 Hari Terakhir
                    </h2>
                    <canvas id="weeklyChart"></canvas>
                </div>

                <!-- Best Sellers -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4">Produk Terlaris</h2>
                    <div class="space-y-4">
                        <div
                            v-for="product in props.statistics.bestSellers"
                            :key="product.produk_id"
                            class="flex justify-between items-center"
                        >
                            <span>{{ product.nama }}</span>
                            <span class="font-semibold"
                                >{{ product.total_sold }} terjual</span
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.scrollbar-thin::-webkit-scrollbar {
    width: 6px;
}

.scrollbar-thin::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.scrollbar-thin::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
