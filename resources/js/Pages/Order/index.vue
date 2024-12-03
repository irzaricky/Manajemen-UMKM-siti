<script setup>
import Hero from "@/Components/Hero.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import debounce from "lodash/debounce";
import { computed, onMounted, ref, watch } from "vue";

const props = defineProps({
    hero: String,
    produks: Object,
    filters: Object,
    cart_session: Object, // Add this prop to receive session data
});

// Add these utility functions
const saveToLocalStorage = (items) => {
    localStorage.setItem("orderItems", JSON.stringify(items));
};

const loadFromLocalStorage = () => {
    const saved = localStorage.getItem("orderItems");
    return saved ? JSON.parse(saved) : {};
};

// Update orderItems ref initialization
const orderItems = ref(loadFromLocalStorage());

// Update productList to account for localStorage items
const productList = ref(
    (props.produks?.data || []).map((produk) => {
        const savedItem = orderItems.value[produk.id];
        return {
            ...produk,
            tempStock: savedItem
                ? produk.stok - savedItem.quantity
                : produk.stok,
        };
    })
);

// Initialize cart from session data on mount
onMounted(() => {
    if (props.cart_session) {
        Object.values(props.cart_session).forEach((item) => {
            orderItems.value[item.id] = {
                id: item.id,
                nama: item.name,
                harga: item.price,
                quantity: item.quantity,
            };

            // Update tempStock
            const product = productList.value.find((p) => p.id === item.id);
            if (product) {
                product.tempStock -= item.quantity;
            }
        });
    }
});

// Computed property for remaining stock
const remainingStock = computed(() => {
    const stockMap = {};
    productList.value.forEach((produk) => {
        stockMap[produk.id] = produk.tempStock;
    });
    return stockMap;
});

// Computed for order total
const orderTotal = computed(() => {
    return Object.values(orderItems.value).reduce((total, item) => {
        return total + item.harga * item.quantity;
    }, 0);
});

// Update increment function
function increment(id) {
    const produk = productList.value.find((p) => p.id === id);
    if (!produk || produk.tempStock <= 0) {
        alert("Stok tidak mencukupi");
        return;
    }

    if (!orderItems.value[id]) {
        orderItems.value[id] = {
            id: produk.id,
            nama: produk.nama,
            harga: produk.harga,
            quantity: 1,
        };
    } else {
        orderItems.value[id].quantity++;
    }

    produk.tempStock--;
    saveToLocalStorage(orderItems.value);
}

// Update decrement function
function decrement(id) {
    const item = orderItems.value[id];
    if (!item || item.quantity <= 0) return;

    const produk = productList.value.find((p) => p.id === id);
    item.quantity--;
    produk.tempStock++;

    if (item.quantity === 0) {
        delete orderItems.value[id];
    }

    saveToLocalStorage(orderItems.value);
}

// Add cleanup on processCheckout
function processCheckout() {
    // Kirim cart ke session melalui route order.add
    router.post(
        route("order.add"),
        {
            items: Object.values(orderItems.value),
        },
        {
            onSuccess: () => {
                localStorage.removeItem("orderItems"); // Clear storage after checkout
                // Setelah berhasil, redirect ke kasir
                router.get(route("order.kasir"));
            },
        }
    );
}

// Search functionality
const search = ref(props.filters?.search || "");

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

watch(search, (value) => {
    performSearch(value);
});

// Computed for quantities (for UI compatibility)
const quantities = computed(() => {
    const qty = {};
    Object.values(orderItems.value).forEach((item) => {
        qty[item.id] = item.quantity;
    });
    return qty;
});

// Computed for cart (for UI compatibility)
const cart = computed(() => Object.values(orderItems.value));
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
                                    v-if="!productList.length"
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
                                    v-for="produk in productList"
                                    :key="produk.id"
                                    class="bg-white shadow rounded-lg p-4"
                                >
                                    <img
                                        v-if="produk.gambar"
                                        :src="`/storage/${produk.gambar}`"
                                        :alt="produk.nama"
                                        loading="lazy"
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
                                            class="text-white font-bold py-2 px-3 rounded bg-[#648374] hover:bg-[#355245]"
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
