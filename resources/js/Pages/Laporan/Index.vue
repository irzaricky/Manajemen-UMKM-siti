<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

defineProps({
    reports: Object,
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString("id-ID", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    });
};

function editReport(report) {
    if (report && report.tanggal) {
        router.get(route("laporan.detail", { date: report.tanggal }));
    } else {
        console.error("Invalid report or missing date:", report);
    }
}
</script>

<template>
    <Head title="Laporan Penjualan" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                >
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">
                            Laporan Penjualan Harian
                        </h2>
                        <a
                            :href="route('laporan.export')"
                            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
                            target="_blank"
                        >
                            Download Excel
                        </a>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Tanggal
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Total Transaksi
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Total Item
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Total Penjualan
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="report in reports.data"
                                    :key="report.id"
                                >
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                    >
                                        {{ formatDate(report.tanggal) }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right"
                                    >
                                        {{ report.total_transaksi }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right"
                                    >
                                        {{ report.total_item }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right"
                                    >
                                        Rp
                                        {{
                                            Number(
                                                report.total_penjualan
                                            ).toLocaleString()
                                        }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-right"
                                    >
                                        <button
                                            @click="editReport(report)"
                                            class="text-indigo-600 hover:text-indigo-900 mr-3"
                                        >
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

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
                            <div class="text-sm text-gray-500">
                                Page {{ reports.current_page }} of
                                {{ reports.last_page }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
