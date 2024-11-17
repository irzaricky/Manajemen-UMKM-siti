<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    reports: Object,
    period: String,
});

const selectedPeriod = ref(props.period);

watch(selectedPeriod, (value) => {
    router.get(
        route("laporan.keuntungan.index"),
        { period: value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString("id-ID");
};

const formatCurrency = (amount) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(amount);
};

const calculateProfit = (total_penjualan, total_modal) => {
    return total_penjualan - (total_modal || 0); // Handle null/undefined modal
};

const calculateMargin = (total_penjualan, total_modal) => {
    const profit = calculateProfit(total_penjualan, total_modal);
    return total_penjualan > 0
        ? ((profit / total_penjualan) * 100).toFixed(2)
        : 0;
};

const formatPeriod = (date, period) => {
    const d = new Date(date);
    switch (period) {
        case "weekly":
            return `Minggu ${d.getWeek()} ${d.getFullYear()}`;
        case "monthly":
            return d.toLocaleDateString("id-ID", {
                year: "numeric",
                month: "long",
            });
        default:
            return formatDate(date);
    }
};
</script>

<template>
    <Head title="Laporan Keuntungan" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                >
                    <!-- Period Selector -->
                    <div class="mb-6">
                        <select
                            v-model="selectedPeriod"
                            class="rounded-md border-gray-300"
                        >
                            <option value="daily">Harian</option>
                            <option value="weekly">Mingguan</option>
                            <option value="monthly">Bulanan</option>
                            <option value="yearly">Tahunan</option>
                        </select>
                    </div>

                    <!-- Table -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left">Tanggal</th>
                                <th class="px-6 py-3 text-right">Penjualan</th>
                                <th class="px-6 py-3 text-right">Pembelian Bahan</th>
                                <th class="px-6 py-3 text-right">Keuntungan</th>
                                <th class="px-6 py-3 text-right">Margin</th>
                                <th class="px-6 py-3 text-right">Items</th>
                                <th class="px-6 py-3 text-right">Produk</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="report in reports.data"
                                :key="report.tanggal"
                            >
                                <td class="px-6 py-4">
                                    {{
                                        formatPeriod(
                                            report.tanggal,
                                            selectedPeriod
                                        )
                                    }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    {{ formatCurrency(report.total_penjualan) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    {{ formatCurrency(report.total_modal) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    {{
                                        formatCurrency(
                                            calculateProfit(
                                                report.total_penjualan,
                                                report.total_modal
                                            )
                                        )
                                    }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    {{
                                        calculateMargin(
                                            report.total_penjualan,
                                            report.total_modal
                                        )
                                    }}%
                                </td>
                                <td class="px-6 py-4 text-right">
                                    {{ report.total_item }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    {{ report.total_produk }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        <div class="flex items-center justify-between">
                            <div class="flex gap-x-2">
                                <Link
                                    v-if="reports.prev_page_url"
                                    :href="reports.prev_page_url"
                                    class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded"
                                >
                                    Previous
                                </Link>
                                <Link
                                    v-if="reports.next_page_url"
                                    :href="reports.next_page_url"
                                    class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded"
                                >
                                    Next
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
