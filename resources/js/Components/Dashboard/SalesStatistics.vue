<script setup>
import { ref, watch } from "vue";

const props = defineProps({
    statistics: Object,
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(value);
};
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            Statistik Penjualan
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Total Pendapatan -->
            <div
                class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white"
            >
                <h3 class="text-lg font-medium mb-2">Total Pendapatan</h3>
                <p class="text-3xl font-bold">
                    {{ formatCurrency(statistics.total_pendapatan || 0) }}
                </p>
            </div>

            <!-- Total Transaksi -->
            <div
                class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white"
            >
                <h3 class="text-lg font-medium mb-2">Total Transaksi</h3>
                <p class="text-3xl font-bold">
                    {{ statistics.total_transaksi || 0 }}
                </p>
            </div>
        </div>
    </div>
</template>
