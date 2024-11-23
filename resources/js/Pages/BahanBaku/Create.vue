<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    nama: "",
    stok: 0,
    satuan: "",
    minimum_stok: 0,
    keterangan: "",
});

function submit() {
    form.post(route("bahan-baku.store"), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head title="Tambah Bahan Baku" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">
                            Form Tambah Bahan Baku
                        </h3>

                        <form @submit.prevent="submit">
                            <!-- Nama -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Nama Bahan</label
                                >
                                <input
                                    v-model="form.nama"
                                    type="text"
                                    maxlength="255"
                                    required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <div
                                    v-if="form.errors.nama"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.nama }}
                                </div>
                            </div>

                            <!-- Stok -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Stok</label
                                >
                                <input
                                    v-model="form.stok"
                                    type="number"
                                    min="0"
                                    required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <div
                                    v-if="form.errors.stok"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.stok }}
                                </div>
                            </div>

                            <!-- Satuan -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Satuan</label
                                >
                                <input
                                    v-model="form.satuan"
                                    type="text"
                                    maxlength="50"
                                    required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <div
                                    v-if="form.errors.satuan"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.satuan }}
                                </div>
                            </div>

                            <!-- Minimum Stok -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Minimum Stok</label
                                >
                                <input
                                    v-model="form.minimum_stok"
                                    type="number"
                                    min="0"
                                    required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <div
                                    v-if="form.errors.minimum_stok"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.minimum_stok }}
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Keterangan</label
                                >
                                <textarea
                                    v-model="form.keterangan"
                                    rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                ></textarea>
                                <div
                                    v-if="form.errors.keterangan"
                                    class="text-red-600 text-sm mt-1"
                                >
                                    {{ form.errors.keterangan }}
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-end">
                                <Link
                                    :href="route('bahan-baku.index')"
                                    class="mr-4 px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-200 transition"
                                >
                                    Batal
                                </Link>
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
