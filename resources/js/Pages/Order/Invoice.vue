<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    transaction: Object,
    source: String,
});

// Format tanggal
const formatDate = (date) => {
    return new Date(date).toLocaleString("id-ID", {
        dateStyle: "long",
        timeStyle: "short",
    });
};

// Compute back route based on source
const backRoute = computed(() => {
    return props.source === "order"
        ? route("order.index")
        : route("laporan.detail", { date: props.transaction.tanggal });
});
</script>

<template>
    <Head title="Invoice" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                >
                    <!-- Header Invoice -->
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-2xl font-bold">Invoice</h2>
                            <p class="text-gray-600">
                                No. Transaksi: #{{ transaction.id }}
                            </p>
                            <p class="text-gray-600">
                                Tanggal: {{ formatDate(transaction.tanggal) }}
                            </p>
                        </div>
                        <div class="text-right">
                            <h3 class="text-lg font-semibold">Warung Siti</h3>
                            <p class="text-gray-600">Jalan Raya No. 123</p>
                            <p class="text-gray-600">Telp: 081234567890</p>
                        </div>
                    </div>

                    <!-- Detail Items -->
                    <div class="mt-8">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                    >
                                        Item
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase"
                                    >
                                        Qty
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase"
                                    >
                                        Harga
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase"
                                    >
                                        Subtotal
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr
                                    v-for="detail in transaction.transaksi_detail"
                                    :key="detail.id"
                                >
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ detail.produk.nama }}
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-900 text-center"
                                    >
                                        {{ detail.jumlah }}
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-900 text-right"
                                    >
                                        Rp
                                        {{
                                            detail.harga_satuan.toLocaleString()
                                        }}
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-900 text-right"
                                    >
                                        Rp
                                        {{
                                            (
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
                                        class="px-6 py-4 text-sm font-bold text-right"
                                    >
                                        Total:
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm font-bold text-right"
                                    >
                                        Rp
                                        {{
                                            transaction.total_harga.toLocaleString()
                                        }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Footer -->
                    <div class="mt-8 text-center text-gray-600">
                        <p>Terima kasih telah berbelanja di Warung Siti</p>
                        <div class="mt-4 flex justify-center gap-4">
                            <Link
                                :href="route('order.index')"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                            >
                                New Order
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
