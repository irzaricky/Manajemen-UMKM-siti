<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    produk: Object,
});

// Inertia useForm untuk mengelola form, dengan data produk yang sudah ada
const form = useForm({
    nama: props.produk.nama,
    tipe: props.produk.tipe,
    harga: props.produk.harga,
    stok: props.produk.stok,
    gambar: props.produk.gambar,
});

// Tambahkan logging untuk melihat data yang dikirim
function submit() {
    form.post(route("dashboard.produk.update", props.produk.id), {
        preserveScroll: true,
    });
}

// Pastikan handleFileChange benar`
function handleFileChange(e) {
    form.gambar = e.target.files[0];
}
</script>

<template>
    <Head title="Edit Produk" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">
                            Form Edit Produk
                        </h3>

                        <!-- Form Input Produk -->
                        <form
                            @submit.prevent="submit"
                            enctype="multipart/form-data"
                        >
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Nama Produk</label
                                >
                                <input
                                    v-model="form.nama"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <div
                                    v-if="form.errors.nama"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.nama }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Tipe Produk</label
                                >
                                <input
                                    v-model="form.tipe"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <div
                                    v-if="form.errors.tipe"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.tipe }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Harga</label
                                >
                                <input
                                    v-model="form.harga"
                                    type="number"
                                    min="0"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <div
                                    v-if="form.errors.harga"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.harga }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Stok</label
                                >
                                <input
                                    v-model="form.stok"
                                    type="number"
                                    min="0"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <div
                                    v-if="form.errors.stok"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.stok }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Gambar Produk
                                </label>
                                <input
                                    type="file"
                                    @input="handleFileChange"
                                    accept="image/*"
                                    class="mt-1 block w-full"
                                />
                                <div
                                    v-if="form.errors.gambar"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.gambar }}
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <Link
                                    :href="route('dashboard.produk.index')"
                                    class="mr-4 px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-200 transition"
                                    >Batal</Link
                                >
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition"
                                >
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
