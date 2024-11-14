<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { computed, ref, watch } from "vue";
import debounce from "lodash/debounce";

const props = defineProps({
    resep: Object,
    filters: Object,
});

const search = ref(props.filters.search);

const performSearch = debounce((value) => {
    router.get(
        route("resep.index"),
        { search: value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}, 300);

watch(search, (value) => {
    performSearch(value);
});
</script>

<template>
    <Head title="Resep" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold">List Resep</h3>
                            <div class="flex items-center">
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Cari resep..."
                                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                />
                            </div>
                        </div>

                        <table
                            class="min-w-full divide-y divide-gray-200 border"
                        >
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-2 text-left text-sm font-semibold text-gray-600"
                                    >
                                        Produk
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-sm font-semibold text-gray-600"
                                    >
                                        Bahan Baku
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-sm font-semibold text-gray-600"
                                    >
                                        Jumlah
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="item in resep.data" :key="item.id">
                                    <td class="px-4 py-2">
                                        {{ item.produk.nama }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ item.bahan_baku.nama }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ item.jumlah_bahan }}
                                        {{ item.bahan_baku.satuan }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
