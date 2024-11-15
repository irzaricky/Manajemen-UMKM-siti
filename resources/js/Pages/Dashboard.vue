<script setup>
import Hero from "@/Components/Hero.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { computed, onMounted, reactive } from "vue";

const props = defineProps({
    hero: String,
    produks: Object,
});

const produkList = computed(() => props.produks.data);

// State global untuk menyimpan jumlah barang berdasarkan ID produk
const quantities = reactive({});

// Muat data dari localStorage saat komponen dimount
onMounted(() => {
    const storedQuantities = JSON.parse(localStorage.getItem("quantities")) || {};
    Object.assign(quantities, storedQuantities);
});

// Fungsi untuk menyimpan data quantities ke localStorage
function saveQuantities() {
    localStorage.setItem("quantities", JSON.stringify(quantities));
}

// Fungsi untuk menambah jumlah barang
function increment(id) {
    if (!quantities[id]) quantities[id] = 0; // Default ke 0 jika belum ada
    quantities[id]++;
    saveQuantities();
}

// Fungsi untuk mengurangi jumlah barang
function decrement(id) {
    if (quantities[id] && quantities[id] > 0) {
        quantities[id]--;
        saveQuantities();
    }
}
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <Hero :heroTitle="props.hero" />
        <div class="py-12">
            <div class="mx-16 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="flex gap-6 p-6">
                        <div class="flex flex-col">
                            <div class="grid grid-cols sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div v-for="produk in produkList" :key="produk.id"
                                    class="bg-white shadow rounded-lg p-4">
                                    <img loading="lazy" src="../../../public/dummy.png" alt="Menu Image"
                                        class="rounded-lg" />
                                    <div class="text-xl font-bold py-2 text-gray-700">
                                        {{ produk.nama }}
                                    </div>
                                    <div class="text-base text-gray-700">
                                        Rp {{ produk.harga.toLocaleString() }}
                                    </div>
                                    <div class="flex items-center justify-start gap-x-4 mt-4">
                                        <button
                                            @click="decrement(produk.id)"
                                            class="text-white font-bold py-2 px-3 rounded bg-red-500 hover:bg-red-700"
                                        >
                                            -
                                        </button>
                                        <span class="text-lg font-semibold">{{ quantities[produk.id] || 0 }}</span>
                                        <button
                                            @click="increment(produk.id)"
                                            class="text-white font-bold py-2 px-3 rounded bg-green-500 hover:bg-green-700"
                                        >
                                            +
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <nav aria-label="Page navigation">
                                <ul class="flex mt-6 gap-5 justify-center items-center font-bold text-gray-500">
                                    <li>
                                        <Link :href="props.produks.prev_page_url"
                                            class="rounded-md transform transition-transform duration-100 hover:scale-105 hover:text-black">
                                        &lt; Prev
                                        </Link>
                                    </li>
                                    <li>
                                        <Link :href="props.produks.next_page_url"
                                            class="rounded-md transform transition-transform duration-100 hover:scale-105 hover:text-black">
                                        Next &gt;
                                        </Link>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="flex flex-col w-[45%]">
                            <h1 class="font-bold text-3xl text-center justify-center">
                                Preview Pesanan
                            </h1>
                            <hr data-layername="allBlogsDivider"
                                class="md:mt-4 mt-3 w-full border border-solid bg-zinc-500 border-zinc-500 min-h-[2px] opacity-[0.32]"
                                aria-hidden="true" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
