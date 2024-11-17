<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    transactions: Object,
    date: String,
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString("id-ID", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    });
};

function confirmDeleteTransaction(transactionId) {
    if (confirm("Apakah Anda yakin ingin menghapus transaksi ini?")) {
        router.delete(route("laporan.transaction.destroy", transactionId));
    }
}
</script>

<template>
    <Head title="Detail Laporan" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                >
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold">
                            Detail Laporan Tanggal {{ formatDate(date) }}
                        </h2>
                        <a
                            :href="route('laporan.index')"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600"
                        >
                            Kembali
                        </a>
                    </div>

                    <!-- Transactions List -->
                    <div
                        v-for="(details, transactionId) in transactions"
                        :key="transactionId"
                        class="mb-8 border rounded-lg p-4"
                    >
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">
                                Transaksi #{{ transactionId }}
                            </h3>
                            <div class="flex gap-2">
                                <button
                                    @click="
                                        confirmDeleteTransaction(transactionId)
                                    "
                                    class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600"
                                >
                                    Hapus
                                </button>
                            </div>
                        </div>

                        <!-- Transaction Details Table -->
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left">Produk</th>
                                    <th class="px-4 py-2 text-right">Jumlah</th>
                                    <th class="px-4 py-2 text-right">
                                        Harga Satuan
                                    </th>
                                    <th class="px-4 py-2 text-right">
                                        Subtotal
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="detail in details"
                                    :key="detail.detail_id"
                                >
                                    <td class="px-4 py-2">
                                        {{ detail.nama_produk }}
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        {{ detail.jumlah }}
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        Rp
                                        {{
                                            Number(
                                                detail.harga_satuan
                                            ).toLocaleString()
                                        }}
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        Rp
                                        {{
                                            Number(
                                                detail.jumlah *
                                                    detail.harga_satuan
                                            ).toLocaleString()
                                        }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td
                                        colspan="3"
                                        class="px-4 py-2 text-right font-bold"
                                    >
                                        Total:
                                    </td>
                                    <td class="px-4 py-2 text-right font-bold">
                                        Rp
                                        {{
                                            Number(
                                                details[0].total_harga
                                            ).toLocaleString()
                                        }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
