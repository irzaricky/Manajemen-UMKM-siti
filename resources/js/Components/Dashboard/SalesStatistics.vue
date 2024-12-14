<script setup>
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    statistics: Object,
    currentPeriod: String,
});

const selectedPeriod = ref(props.currentPeriod);

watch(selectedPeriod, (value) => {
    router.get(route("dashboard"), { period: value }, { preserveState: true });
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
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">
                Statistik Penjualan
            </h2>
            <select
                v-model="selectedPeriod"
                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
                <option value="daily">Hari Ini</option>
                <option value="weekly">Minggu Ini</option>
                <option value="monthly">Bulan Ini</option>
            </select>
        </div>

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
