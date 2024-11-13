<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps({
    transaction: Object,
});

const form = useForm({
    details: props.transaction.map((detail) => ({
        detail_id: detail.detail_id,
        produk_id: detail.produk_id,
        nama_produk: detail.nama_produk,
        jumlah: detail.jumlah,
        harga_satuan: detail.harga_satuan,
    })),
    tanggal: props.transaction[0].tanggal,
});

function submit() {
    form.put(route("laporan.transaction.update", props.transaction[0].id));
}

const calculateSubtotal = (detail) => {
    return detail.jumlah * detail.harga_satuan;
};

const calculateTotal = () => {
    return form.details.reduce(
        (total, detail) => total + calculateSubtotal(detail),
        0
    );
};
</script>

<template>
    <Head title="Edit Transaksi" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                >
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold">
                            Edit Transaksi #{{ props.transaction[0].id }}
                        </h2>
                
                    </div>

                    <form @submit.prevent="submit">
                        <!-- Transaction Details Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase"
                                        >
                                            Produk
                                        </th>
                                        <th
                                            class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase w-32"
                                        >
                                            Jumlah
                                        </th>
                                        <th
                                            class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase"
                                        >
                                            Subtotal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr
                                        v-for="(detail, index) in form.details"
                                        :key="detail.detail_id"
                                    >
                                        <td class="px-4 py-2">
                                            {{ detail.nama_produk }}
                                        </td>
                                        <td class="px-4 py-2 text-right">
                                            <div class="flex justify-end">
                                                <input
                                                    type="number"
                                                    v-model="detail.jumlah"
                                                    class="w-20 text-right rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                    min="1"
                                                    required
                                                />
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 text-right">
                                            Rp
                                            {{
                                                calculateSubtotal(
                                                    detail
                                                ).toLocaleString()
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td
                                            colspan="2"
                                            class="px-4 py-2 text-right font-bold"
                                        >
                                            Total:
                                        </td>
                                        <td
                                            class="px-4 py-2 text-right font-bold"
                                        >
                                            Rp
                                            {{
                                                calculateTotal().toLocaleString()
                                            }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Error Messages -->
                        <div
                            v-if="form.errors.details"
                            class="mt-2 text-red-600 text-sm"
                        >
                            {{ form.errors.details }}
                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-6 flex justify-end gap-4">
                            <a
                                :href="
                                    route('laporan.detail', {
                                        date: form.tanggal,
                                    })
                                "
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400"
                            >
                                Batal
                            </a>
                            <button
                                type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                                :disabled="form.processing"
                            >
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
