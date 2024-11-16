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

const deleteResep = (id) => {
    if (confirm("Are you sure you want to delete this recipe?")) {
        router.delete(route("resep.destroy", id));
    }
};
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

                            <!-- Search Input -->
                            <div class="flex items-center">
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Cari resep..."
                                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                />
                            </div>

                            <!-- Pagination Navigation -->
                            <nav aria-label="Page navigation">
                                <ul class="flex space-x-2">
                                    <li>
                                        <Link
                                            :href="resep.prev_page_url"
                                            class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-200 transition"
                                            :class="{
                                                'opacity-50 cursor-not-allowed':
                                                    !resep.prev_page_url,
                                            }"
                                        >
                                            Previous
                                        </Link>
                                    </li>
                                    <li>
                                        <Link
                                            :href="resep.next_page_url"
                                            class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-200 transition"
                                            :class="{
                                                'opacity-50 cursor-not-allowed':
                                                    !resep.next_page_url,
                                            }"
                                        >
                                            Next
                                        </Link>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <!-- Table -->
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
                                    <th
                                        class="px-4 py-2 text-center text-sm font-semibold text-gray-600"
                                    >
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="item in resep.data" :key="item.id">
                                    <td class="px-4 py-2 text-sm text-gray-700">
                                        {{ item.produk.nama }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-700">
                                        {{ item.bahan_baku.nama }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-700">
                                        {{ item.jumlah_bahan }}
                                        {{ item.bahan_baku.satuan }}
                                    </td>
                                    <td
                                        class="px-4 py-2 text-sm text-white flex justify-center gap-x-4"
                                    >
                                        <Link
                                            :href="route('resep.edit', item.id)"
                                            class="font-bold py-2 px-4 rounded bg-blue-600 hover:bg-blue-700"
                                        >
                                            Edit
                                        </Link>
                                        <button
                                            @click="deleteResep(item.id)"
                                            class="font-bold py-2 px-4 rounded bg-red-500 hover:bg-red-700"
                                        >
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Add Button -->
                        <button
                            class="float-right my-8 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                            @click="$inertia.get(route('resep.create'))"
                        >
                            Tambah Resep
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
