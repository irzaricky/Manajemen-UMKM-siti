<script setup>
import Hero from "@/Components/Hero.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { computed, ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import debounce from "lodash/debounce";

const props = defineProps({
    hero: String,
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

// Stock threshold constants
const LOW_STOCK_THRESHOLD = 3;
const MEDIUM_STOCK_THRESHOLD = 6;

function getStockClass(stok) {
    if (stok <= LOW_STOCK_THRESHOLD) {
        return "text-red-600 font-semibold";
    } else if (stok <= MEDIUM_STOCK_THRESHOLD) {
        return "text-yellow-600";
    }
    return "text-green-600";
}

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
                                            :class="{
                                                'opacity-50 cursor-not-allowed':
                                                    !produks.prev_page_url,
                                            }"
                                        >
                                            Previous
                                        </Link>
                                    </li>
                                    <li>
                                        <Link
                                            :href="props.produks.next_page_url"
                                            class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-200 transition"
                                            :class="{
                                                'opacity-50 cursor-not-allowed':
                                                    !produks.next_page_url,
                                            }"
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
                                        Gambar
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
                                    <td class="px-4 py-2">
                                        <div
                                            class="h-16 w-16 overflow-hidden rounded-lg"
                                        >
                                            <img
                                                v-if="produk.gambar"
                                                :src="`/storage/${produk.gambar}`"
                                                :alt="produk.nama"
                                                class="h-full w-full object-cover"
                                            />
                                            <div
                                                v-else
                                                class="flex h-full w-full items-center justify-center bg-gray-100"
                                            >
                                                <span
                                                    class="text-xs text-gray-400"
                                                    >No Image</span
                                                >
                                            </div>
                                        </div>
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
                                    <td
                                        class="px-4 py-2 text-sm"
                                        :class="getStockClass(produk.stok)"
                                    >
                                        {{ produk.stok }}
                                        <span
                                            v-if="
                                                produk.stok <=
                                                LOW_STOCK_THRESHOLD
                                            "
                                            class="text-xs ml-1"
                                        >
                                            (Stok Menipis!)
                                        </span>
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
                                            class="font-bold py-2 px-4 rounded bg-blue-600 hover:bg-blue-700"
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
