<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { computed, ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import debounce from "lodash/debounce";

const props = defineProps({
    produks: Object,
    filters: Object,
});

const produkList = computed(() => props.produks.data);
const search = ref(props.filters.search);

// Debounced search function
const performSearch = debounce((value) => {
    router.get(
        route("dashboard.produk.index"),
        { search: value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}, 300);

// Watch for search input changes
watch(search, (value) => {
    performSearch(value);
});

function deleteProduct(produk) {
    if (confirm(`Apakah Anda yakin ingin menghapus produk "${produk.nama}"?`)) {
        Inertia.delete(route("dashboard.produk.delete", produk.id));
    }
}
</script>

<template>
    <Head title="Produk" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold">List Produk</h3>

                            <!-- Search Input -->
                            <div class="flex items-center">
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Cari produk..."
                                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                />
                            </div>

                            <!-- Navigasi Paginasi -->
                            <nav aria-label="Page navigation">
                                <ul class="flex space-x-2">
                                    <li>
                                        <Link
                                            :href="props.produks.prev_page_url"
                                            class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-200 transition"
                                        >
                                            Previous
                                        </Link>
                                    </li>
                                    <li>
                                        <Link
                                            :href="props.produks.next_page_url"
                                            class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-200 transition"
                                        >
                                            Next
                                        </Link>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <!-- Tabel Produk -->
                        <table
                            class="min-w-full divide-y divide-gray-200 border"
                        >
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-2 text-left text-sm font-semibold text-gray-600"
                                    >
                                        ID
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-sm font-semibold text-gray-600"
                                    >
                                        Nama
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-sm font-semibold text-gray-600"
                                    >
                                        Tipe
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-sm font-semibold text-gray-600"
                                    >
                                        Harga
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-sm font-semibold text-gray-600"
                                    >
                                        Stok
                                    </th>
                                    <th
                                        class="px-4 py-2 text-center text-sm font-semibold text-gray-600"
                                    >
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="produk in produkList"
                                    :key="produk.id"
                                >
                                    <td class="px-4 py-2 text-sm text-gray-700">
                                        {{ produk.id }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-700">
                                        {{ produk.nama }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-700">
                                        {{ produk.tipe }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-700">
                                        Rp {{ produk.harga.toLocaleString() }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-700">
                                        {{ produk.stok }}
                                    </td>
                                    <td
                                        class="py-2 text-sm text-white flex justify-center gap-x-4"
                                    >
                                        <Button
                                            @click="
                                                $inertia.get(
                                                    route(
                                                        'dashboard.produk.edit',
                                                        produk.id
                                                    )
                                                )
                                            "
                                            class="font-bold py-2 px-4 rounded bg-slate-500 hover:bg-slate-700"
                                        >
                                            Edit
                                        </Button>
                                        <Button
                                            @click="deleteProduct(produk)"
                                            class="font-bold py-2 px-4 rounded bg-red-500 hover:bg-red-700"
                                        >
                                            Hapus
                                        </Button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button
                            class="float-right my-8 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                            @click="
                                $inertia.get(route('dashboard.produk.create'))
                            "
                        >
                            Tambah Produk
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
