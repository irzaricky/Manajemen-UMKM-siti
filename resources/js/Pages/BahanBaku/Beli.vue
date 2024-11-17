<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const props = defineProps({
    bahanBaku: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    bahan_baku_id: props.bahanBaku.id,
    jumlah: "",
    harga_per_unit: "",
    tanggal_pembelian: "",
    nomor_invoice: "",
    keterangan: "",
});

const total = ref(0);

// Hitung total otomatis saat jumlah atau harga berubah
watch(
    [() => form.jumlah, () => form.harga_per_unit],
    ([newJumlah, newHarga]) => {
        total.value = newJumlah * newHarga;
    }
);

function submit() {
    form.post(route("bahan-baku.storePembelian"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            total.value = 0;
        },
    });
}
</script>

<template>
    <Head title="Pembelian Bahan Baku" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Tambah tombol back -->
                        <div class="mb-4">
                            <Link
                                :href="route('bahan-baku.index')"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 mr-1"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"
                                    />
                                </svg>
                                Kembali
                            </Link>
                        </div>

                        <h2 class="text-lg font-semibold mb-4">
                            Form Pembelian {{ bahanBaku.nama }}
                        </h2>

                        <form @submit.prevent="submit">
                            <!-- Nomor Invoice -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Nomor Invoice
                                </label>
                                <input
                                    v-model="form.nomor_invoice"
                                    type="text"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300"
                                />
                            </div>

                            <!-- Jumlah -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Jumlah ({{ bahanBaku.satuan }})
                                </label>
                                <input
                                    v-model="form.jumlah"
                                    type="number"
                                    min="1"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300"
                                />
                            </div>

                            <!-- Harga Per Unit -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Harga Per {{ bahanBaku.satuan }}
                                </label>
                                <input
                                    v-model="form.harga_per_unit"
                                    type="number"
                                    min="0"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300"
                                />
                            </div>

                            <!-- Total Harga (Readonly) -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Total Harga
                                </label>
                                <input
                                    :value="'Rp ' + total.toLocaleString()"
                                    readonly
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50"
                                />
                            </div>

                            <!-- Tanggal Pembelian -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Tanggal Pembelian
                                </label>
                                <input
                                    v-model="form.tanggal_pembelian"
                                    type="date"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300"
                                />
                            </div>

                            <!-- Keterangan -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Keterangan
                                </label>
                                <textarea
                                    v-model="form.keterangan"
                                    rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300"
                                ></textarea>
                            </div>

                            <div class="flex justify-end space-x-3">
                                <Link
                                    :href="route('bahan-baku.index')"
                                    class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400"
                                >
                                    Batal
                                </Link>
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                                >
                                    Simpan Pembelian
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
