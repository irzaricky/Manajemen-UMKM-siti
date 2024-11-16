<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps({
    resep: Object,
    produk: Array,
    bahanBaku: Array,
});

const form = useForm({
    produk_id: props.resep.produk_id,
    bahan_baku_id: props.resep.bahan_baku_id,
    jumlah_bahan: props.resep.jumlah_bahan,
});

const submit = () => {
    form.put(route("resep.update", props.resep.id));
};
</script>

<template>
    <Head title="Edit Resep" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Produk</label
                                >
                                <select
                                    v-model="form.produk_id"
                                    class="mt-1 block w-full rounded-md border-gray-300"
                                >
                                    <option value="">Pilih Produk</option>
                                    <option
                                        v-for="item in produk"
                                        :key="item.id"
                                        :value="item.id"
                                    >
                                        {{ item.nama }}
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Bahan Baku</label
                                >
                                <select
                                    v-model="form.bahan_baku_id"
                                    class="mt-1 block w-full rounded-md border-gray-300"
                                >
                                    <option value="">Pilih Bahan Baku</option>
                                    <option
                                        v-for="item in bahanBaku"
                                        :key="item.id"
                                        :value="item.id"
                                    >
                                        {{ item.nama }}
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Jumlah Bahan</label
                                >
                                <input
                                    type="number"
                                    v-model="form.jumlah_bahan"
                                    class="mt-1 block w-full rounded-md border-gray-300"
                                />
                            </div>

                            <div class="flex justify-end">
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                                >
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
