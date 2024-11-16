<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { computed, ref, watch } from "vue";
import debounce from "lodash/debounce";
import Modal from "@/Components/Modal.vue";

const props = defineProps({
    bahanBaku: Object,
    filters: Object,
});

const search = ref(props.filters.search);

const performSearch = debounce((value) => {
    router.get(
        route("bahan-baku.index"),
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

const showDeleteModal = ref(false);
const bahanToDelete = ref(null);

const confirmDelete = (bahan) => {
    bahanToDelete.value = bahan;
    showDeleteModal.value = true;
};

const closeModal = () => {
    showDeleteModal.value = false;
    bahanToDelete.value = null;
};

const deleteBahanBaku = () => {
    router.delete(route("bahan-baku.destroy", bahanToDelete.value.id), {
        onSuccess: () => {
            closeModal();
        },
    });
};
</script>

<template>
    <Head title="Bahan Baku" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold">
                                List Bahan Baku
                            </h3>

                            <!-- Search Input -->
                            <div class="flex items-center">
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Cari bahan baku..."
                                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                />
                            </div>

                            <!-- Pagination Navigation -->
                            <nav aria-label="Page navigation">
                                <ul class="flex space-x-2">
                                    <li>
                                        <Link
                                            :href="bahanBaku.prev_page_url"
                                            class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-200 transition"
                                            :class="{
                                                'opacity-50 cursor-not-allowed':
                                                    !bahanBaku.prev_page_url,
                                            }"
                                        >
                                            Previous
                                        </Link>
                                    </li>
                                    <li>
                                        <Link
                                            :href="bahanBaku.next_page_url"
                                            class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-200 transition"
                                            :class="{
                                                'opacity-50 cursor-not-allowed':
                                                    !bahanBaku.next_page_url,
                                            }"
                                        >
                                            Next
                                        </Link>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <table
                            class="min-w-full divide-y divide-gray-200 border"
                        >
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-2 text-left text-sm font-semibold text-gray-600"
                                    >
                                        Nama
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-sm font-semibold text-gray-600"
                                    >
                                        Stok
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-sm font-semibold text-gray-600"
                                    >
                                        Satuan
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-sm font-semibold text-gray-600"
                                    >
                                        Harga Per Unit
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-sm font-semibold text-gray-600"
                                    >
                                        Minimum Stok
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-sm font-semibold text-gray-600"
                                    >
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="bahan in bahanBaku.data"
                                    :key="bahan.id"
                                >
                                    <td class="px-4 py-2">{{ bahan.nama }}</td>
                                    <td
                                        class="px-4 py-2"
                                        :class="{
                                            'text-red-600':
                                                bahan.stok <=
                                                bahan.minimum_stok,
                                        }"
                                    >
                                        {{ bahan.stok }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ bahan.satuan }}
                                    </td>
                                    <td class="px-4 py-2">
                                        Rp
                                        {{
                                            bahan.harga_per_unit.toLocaleString()
                                        }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ bahan.minimum_stok }}
                                    </td>
                                    <td class="px-4 py-2 space-x-2">
                                        <Link
                                            :href="
                                                route(
                                                    'bahan-baku.edit',
                                                    bahan.id
                                                )
                                            "
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700"
                                        >
                                            Edit
                                        </Link>
                                        <button
                                            @click="confirmDelete(bahan)"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700"
                                        >
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button
                            class="float-right my-8 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                            @click="$inertia.get(route('bahan-baku.create'))"
                        >
                            Tambah Produk
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <Modal :show="showDeleteModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium">Konfirmasi Hapus</h2>
                <p class="mt-2">
                    Apakah Anda yakin ingin menghapus bahan baku ini?
                </p>
                <div class="mt-6 flex justify-end space-x-4">
                    <button
                        class="px-4 py-2 bg-gray-300 rounded-md"
                        @click="closeModal"
                    >
                        Batal
                    </button>
                    <button
                        class="px-4 py-2 bg-red-600 text-white rounded-md"
                        @click="deleteBahanBaku"
                    >
                        Hapus
                    </button>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
