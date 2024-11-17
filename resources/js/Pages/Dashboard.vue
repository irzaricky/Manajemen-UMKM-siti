<script setup>
import Hero from "@/Components/Hero.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    statistics: Object,
    hero: String,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <Hero :heroTitle="hero" />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Today's Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold mb-4">
                            Penjualan Hari Ini
                        </h2>
                        <p class="text-3xl font-bold">
                            Rp
                            {{
                                statistics.totalPenjualanHariIni.toLocaleString()
                            }}
                        </p>
                        <p class="text-gray-600">
                            {{ statistics.totalTransaksiHariIni }} Transaksi
                        </p>
                    </div>

                    <!-- Low Stock Warnings -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold mb-4">Stok Menipis</h2>
                        <div class="space-y-2">
                            <div
                                v-for="product in statistics.productLowStock"
                                :key="product.id"
                            >
                                <p class="text-red-600">
                                    {{ product.nama }} ({{ product.stok }}
                                    tersisa)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales Chart -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">
                        Penjualan 7 Hari Terakhir
                    </h2>
                    <!-- Implement chart here using Chart.js or similar -->
                </div>

                <!-- Best Sellers -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4">Produk Terlaris</h2>
                    <div class="space-y-4">
                        <div
                            v-for="product in statistics.bestSellers"
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
