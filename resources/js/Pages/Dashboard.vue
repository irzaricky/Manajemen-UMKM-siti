<script setup>
import Hero from "@/Components/Hero.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
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
const cart = reactive([]);

// Muat data dari localStorage saat komponen dimount
onMounted(() => {
    const storedQuantities = JSON.parse(localStorage.getItem("quantities")) || {};
    const storedCart = JSON.parse(localStorage.getItem("cart")) || [];

    Object.assign(quantities, storedQuantities);
    cart.push(...storedCart);
});

// Fungsi untuk menyimpan data quantities ke localStorage
function saveQuantities() {
    localStorage.setItem("quantities", JSON.stringify(quantities));
    localStorage.setItem("cart", JSON.stringify(cart));
}

// Fungsi untuk menambah jumlah barang
function increment(id) {
    const produk = produkList.value.find((p) => p.id === id);

    if (produk.stok > (quantities[id] || 0)) {
        if (!quantities[id]) quantities[id] = 0; // Default ke 0 jika belum ada
        quantities[id]++;
        saveQuantities();
        addToCart(id);
    }
}

// Fungsi untuk mengurangi jumlah barang
function decrement(id) {
    if (quantities[id] && quantities[id] > 0) {
        quantities[id]--;
        saveQuantities();
        removeFromCart(id);
    }
}

function addToCart(id) {
    const produk = produkList.value.find((p) => p.id === id);
    const existingItem = cart.find((item) => item.id === id);

    if (existingItem) {
        existingItem.quantity = quantities[id];
    } else {
        cart.push({ ...produk, quantity: quantities[id] });
    }

    saveQuantities();
}

function removeFromCart(id) {
    const index = cart.findIndex((item) => item.id === id);

    if (index !== -1 && quantities[id] === 0) {
        cart.splice(index, 1);
    } else if (index !== -1) {
        cart[index].quantity = quantities[id];
    }

    saveQuantities();
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
                                        <button @click="decrement(produk.id)" :disabled="quantities[produk.id] === 0"
                                            class="text-white font-bold py-2 px-3 rounded bg-red-500 hover:bg-red-700">
                                            -
                                        </button>
                                        <span class="text-lg font-semibold">{{ quantities[produk.id] || 0 }}</span>
                                        <button @click="increment(produk.id)"
                                            :disabled="produk.stok === 0 || quantities[produk.id] >= produk.stok"
                                            :class="{
                                                'bg-gray-400 cursor-not-allowed': produk.stok === 0 || quantities[produk.id] >= produk.stok,
                                                'bg-green-500 hover:bg-green-700': produk.stok > 0 && quantities[produk.id] < produk.stok
                                            }" class="text-white font-bold py-2 px-3 rounded">
                                            +
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <nav aria-label="Page navigation">
                                <ul class="flex mt-6 gap-5 justify-center items-center font-bold text-gray-500">
                                    <li>
                                        <Link :href="props.produks.prev_page_url"
                                            class="rounded-md transform transition-transform duration-100 hover:scale-105 hover:text-black text-xl">
                                        &lt; Prev
                                        </Link>
                                    </li>
                                    <li>
                                        <Link :href="props.produks.next_page_url"
                                            class="rounded-md transform transition-transform duration-100 hover:scale-105 hover:text-black text-xl">
                                        Next &gt;
                                        </Link>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div
                            class="shrink-0 md:rotate-0 border border-solid opacity-40 bg-zinc-500 border-zinc-500 mx-5 hidden md:block">
                        </div>
                        <div class="flex flex-col w-[45%]">
                            <h1 class="font-bold text-3xl text-center justify-center">
                                Preview Pesanan
                            </h1>
                            <hr data-layername="pembatas preview pesanan"
                                class="md:mt-4 mt-3 w-full border border-solid bg-zinc-500 border-zinc-500 min-h-[2px] opacity-[0.32]"
                                aria-hidden="true" />
                            <div class="bg-gray-200 mt-4 rounded-lg">
                                <div class="p-4">
                                    <div v-for="item in cart" :key="item.id"
                                        class="flex items-center justify-between border-b py-2">
                                        <div>
                                            <p class="text-sm font-semibold">{{ item.nama }}</p>
                                            <p class="text-sm text-gray-600">
                                                Rp {{ item.harga.toLocaleString() }} x {{ item.quantity }}
                                            </p>
                                        </div>
                                        <p class="text-sm font-bold">
                                            Rp {{ (item.harga * item.quantity).toLocaleString() }}
                                        </p>
                                    </div>
                                    <hr data-layername="pembatas preview pesanan"
                                        class="md:mt-4 mt-3 w-full border border-solid bg-zinc-500 border-zinc-500 min-h-[2px] opacity-[0.32]"
                                        aria-hidden="true" />
                                    <div class="flex justify-between border-t pt-2">
                                        <p class="text-lg font-semibold text-right">
                                            Total:
                                        </p>
                                        <p class="text-lg font-semibold text-right">Rp {{
                                            cart.reduce((total, item) => total + item.harga * item.quantity,
                                                0).toLocaleString()
                                        }}</p>
                                    </div>
                                    <div class="mt-4 flex items-center justify-center">
                                        <PrimaryButton v-if="cart.length > 0">
                                            Proceed to Checkout
                                        </PrimaryButton>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
