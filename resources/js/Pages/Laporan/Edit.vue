<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps({
    report: Object,
});

const form = useForm({
    id: props.report.id,
    tanggal: props.report.tanggal,
    total_penjualan: props.report.total_penjualan,
    total_item: props.report.total_item,
    total_transaksi: props.report.total_transaksi,
});

function submit() {
    form.put(route('laporan.update', props.report.id));
}
</script>

<template>
    <Head title="Edit Laporan" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-xl font-bold mb-4">Edit Laporan Penjualan</h2>
                    
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Total Penjualan</label>
                            <input
                                v-model="form.total_penjualan"
                                type="number"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                required
                            >
                            <div v-if="form.errors.total_penjualan" class="text-red-500 text-sm mt-1">
                                {{ form.errors.total_penjualan }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Total Item</label>
                            <input
                                v-model="form.total_item"
                                type="number"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Total Transaksi</label>
                            <input
                                v-model="form.total_transaksi"
                                type="number"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                required
                            >
                        </div>

                        <div class="flex justify-end gap-4">
                            <a
                                :href="route('laporan.index')"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400"
                            >
                                Batal
                            </a>
                            <button
                                type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                                :disabled="form.processing"
                            >
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>