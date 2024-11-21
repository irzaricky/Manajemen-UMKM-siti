<script setup>
import Hero from "@/Components/Hero.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import debounce from "lodash/debounce";
import { computed, onMounted, reactive, ref, watch } from "vue";

const props = defineProps({
    hero: String,
    produks: Object,
    filters: Object,
});

const produkList = computed(() => props.produks?.data || []);

// State management
const quantities = reactive({});
const cart = reactive([]);

// Compute remaining stock for each product
const remainingStock = computed(() => {
    const stockMap = {};
    produkList.value.forEach((produk) => {
        const cartItem = cart.find((item) => item.id === produk.id);
        stockMap[produk.id] = produk.stok - (cartItem?.quantity || 0);
    });
    return stockMap;
});

// Load cart data from localStorage
onMounted(() => {
    try {
        const storedQuantities = JSON.parse(localStorage.getItem("quantities"));
        const storedCart = JSON.parse(localStorage.getItem("cart"));

        if (storedQuantities && typeof storedQuantities === "object") {
            Object.assign(quantities, storedQuantities);
        }

        if (Array.isArray(storedCart)) {
            cart.push(...storedCart);
        }
    } catch (error) {
        console.error("Error loading cart data:", error);
        Object.assign(quantities, {});
        cart.length = 0;
    }
});

// Watch for cart changes and sync with localStorage
watch(() => [...cart], saveCartData, { deep: true });
watch(quantities, saveCartData, { deep: true });

// Save cart data to localStorage
function saveCartData() {
    try {
        localStorage.setItem("quantities", JSON.stringify(quantities));
        localStorage.setItem("cart", JSON.stringify(cart));
    } catch (error) {
        console.error("Error saving cart data:", error);
    }
}

// Improved increment with stock validation
function increment(id) {
    const produk = produkList.value.find((p) => p.id === id);
    if (!produk) return;

    const currentQty = quantities[id] || 0;

    if (currentQty >= produk.stok) {
        alert("Stok tidak mencukupi");
        return;
    }

    quantities[id] = currentQty + 1;
    addToCart(id);
}

// Fungsi untuk mengurangi jumlah barang
function decrement(id) {
    if (quantities[id] && quantities[id] > 0) {
        quantities[id]--;
        saveCartData(); // Changed from saveQuantities
        removeFromCart(id);
    }
}

function addToCart(id) {
    const produk = produkList.value.find((p) => p.id === id);
    const existingItem = cart.find((item) => item.id === id);

    if (existingItem) {
        existingItem.quantity = quantities[id];
    } else {
        cart.push({
            id: produk.id,
            nama: produk.nama,
            harga: produk.harga,
            quantity: quantities[id],
            stok: produk.stok,
        });
    }

    saveCartData();
}

function removeFromCart(id) {
    const index = cart.findIndex((item) => item.id === id);

    if (index !== -1 && quantities[id] === 0) {
        cart.splice(index, 1);
    } else if (index !== -1) {
        cart[index].quantity = quantities[id];
    }

    saveCartData(); // Changed from saveQuantities
}

// Fungsi untuk menghapus cart dan quantities dari localStorage
function clearCart() {
    localStorage.removeItem("cart"); // Hapus cart dari localStorage
    localStorage.removeItem("quantities"); // Hapus quantities dari localStorage
    cart.length = 0; // Reset cart array
    // Reset quantities untuk semua produk dalam produkList
    produkList.value.forEach((produk) => {
        quantities[produk.id] = 0; // Set default ke 0 jika belum ada
    });
    saveCartData(); // Changed from saveQuantities
}

// Process checkout
function processCheckout() {
    router.get(route("order.kasir"), { cart });
}

// Add search state
const search = ref(props.filters?.search || "");

// Add debounced search function
const performSearch = debounce((value) => {
    router.get(
        route("order.index"),
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

// Tambahkan class untuk mencegah scrollbar shift
const preventScrollbarShift = {
    mounted() {
        document.body.style.paddingRight =
            window.innerWidth - document.documentElement.clientWidth + "px";
    },
    unmounted() {
        document.body.style.paddingRight = "";
    },
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <Hero :heroTitle="props.hero" />
        <div class="py-12">
            <div class="mx-16 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <!-- Add search input -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h2 class="text-xl font-semibold text-gray-800">
                                Menu
                            </h2>
                            <div class="flex items-center">
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Cari menu..."
                                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#648374] focus:border-[#648374] transition-colors"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-6 p-6">
                        <div class="flex flex-col w-2/3">
                            <div
                                class="grid grid-cols sm:grid-cols-2 lg:grid-cols-3 gap-6"
                            >
                                <div
                                    v-if="!produkList.length"
                                    class="col-span-full flex flex-col items-center justify-center p-8 bg-gray-50 rounded-lg"
                                >
                                    <p class="text-gray-500 text-lg">
                                        Tidak ada menu yang ditemukan
                                    </p>
                                    <p class="text-gray-400">
                                        Coba kata kunci pencarian lain
                                    </p>
                                </div>
                                <div
                                    v-else
                                    v-for="produk in produkList"
                                    :key="produk.id"
                                    class="bg-white shadow rounded-lg p-4"
                                >
                                    <img
                                        loading="lazy"
                                        src="../../../../public/dummy.png"
                                        alt="Menu Image"
                                        class="rounded-lg"
                                    />
                                    <div
                                        class="text-xl font-bold py-2 text-gray-700"
                                    >
                                        {{ produk.nama }}
                                    </div>
                                    <div class="text-base text-gray-700">
                                        Rp {{ produk.harga.toLocaleString() }}
                                    </div>
                                    <!-- Add remaining stock display -->
                                    <div
                                        class="text-sm mt-1"
                                        :class="{
                                            'text-red-600':
                                                remainingStock[produk.id] <= 5,
                                            'text-yellow-600':
                                                remainingStock[produk.id] > 5 &&
                                                remainingStock[produk.id] <= 10,
                                            'text-green-600':
                                                remainingStock[produk.id] > 10,
                                        }"
                                    >
                                        Stok tersisa:
                                        {{ remainingStock[produk.id] }}
                                    </div>
                                    <div
                                        class="flex items-center justify-start gap-x-4 mt-4"
                                    >
                                        <button
                                            @click="decrement(produk.id)"
                                            :disabled="
                                                quantities[produk.id] === 0
                                            "
                                            class="text-white font-bold py-2 px-3 rounded bg-red-500 hover:bg-red-700"
                                        >
                                            -
                                        </button>
                                        <span class="text-lg font-semibold">{{
                                            quantities[produk.id] || 0
                                        }}</span>
                                        <button
                                            @click="increment(produk.id)"
                                            :disabled="
                                                produk.stok === 0 ||
                                                quantities[produk.id] >=
                                                    produk.stok
                                            "
                                            class="text-white font-bold py-2 px-3 rounded bg-[#648374]"
                                            :class="{
                                                'bg-gray-400 hover:bg-gray-500 cursor-not-allowed':
                                                    produk.stok === 0 ||
                                                    quantities[produk.id] >=
                                                        produk.stok,
                                                'bg-[#648374] hover:bg-[#355245]':
                                                    produk.stok > 0 &&
                                                    quantities[produk.id] <
                                                        produk.stok,
                                            }"
                                        >
                                            +
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <nav aria-label="Page navigation">
                                <ul
                                    class="flex mt-6 gap-5 justify-center items-center font-bold text-gray-500"
                                >
                                    <li v-if="props.produks.prev_page_url">
                                        <Link
                                            :href="props.produks.prev_page_url"
                                            class="rounded-md transform transition-transform duration-100 hover:scale-105 hover:text-black text-xl"
                                        >
                                            &lt; Prev
                                        </Link>
                                    </li>
                                    <li v-if="props.produks.next_page_url">
                                        <Link
                                            :href="props.produks.next_page_url"
                                            class="rounded-md transform transition-transform duration-100 hover:scale-105 hover:text-black text-xl"
                                        >
                                            Next &gt;
                                        </Link>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="w-1/3 sticky top-4">
                            <div class="bg-white shadow-lg rounded-lg p-6">
                                <h1
                                    class="font-bold text-3xl text-center justify-center"
                                >
                                    Preview Pesanan
                                </h1>
                                <hr
                                    data-layername="pembatas preview pesanan"
                                    class="md:mt-4 mt-3 w-full border border-solid bg-zinc-500 border-zinc-500 min-h-[2px] opacity-[0.32]"
                                    aria-hidden="true"
                                />
                                <div class="bg-gray-200 mt-4 rounded-lg">
                                    <div class="p-4">
                                        <div
                                            v-for="item in cart"
                                            :key="item.id"
                                            class="flex items-center justify-between border-b py-2"
                                        >
                                            <div>
                                                <p
                                                    class="text-sm font-semibold"
                                                >
                                                    {{ item.nama }}
                                                </p>
                                                <p
                                                    class="text-sm text-gray-600"
                                                >
                                                    Rp
                                                    {{
                                                        item.harga.toLocaleString()
                                                    }}
                                                    x {{ item.quantity }}
                                                </p>
                                            </div>
                                            <p class="text-sm font-bold">
                                                Rp
                                                {{
                                                    (
                                                        item.harga *
                                                        item.quantity
                                                    ).toLocaleString()
                                                }}
                                            </p>
                                        </div>
                                        <hr
                                            data-layername="pembatas preview pesanan"
                                            class="md:mt-4 mt-3 w-full border border-solid bg-zinc-500 border-zinc-500 min-h-[2px] opacity-[0.32]"
                                            aria-hidden="true"
                                        />
                                        <div
                                            class="flex justify-between border-t pt-2"
                                        >
                                            <p
                                                class="text-lg font-semibold text-right"
                                            >
                                                Total:
                                            </p>
                                            <p
                                                class="text-lg font-semibold text-right"
                                            >
                                                Rp
                                                {{
                                                    cart
                                                        .reduce(
                                                            (total, item) =>
                                                                total +
                                                                item.harga *
                                                                    item.quantity,
                                                            0
                                                        )
                                                        .toLocaleString()
                                                }}
                                            </p>
                                        </div>
                                        <div
                                            class="mt-4 flex items-center justify-center"
                                        >
                                            <PrimaryButton
                                                v-if="cart.length > 0"
                                                @click="processCheckout"
                                            >
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
        </div>
    </AuthenticatedLayout>
</template>

<style>
/* Tambahkan CSS untuk memastikan layout tetap stabil */
.sticky {
    position: sticky;
    height: fit-content;
}
</style>
