<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
    products: Array,
});

// Convert products array to reactive ref with temporary stock
const productList = ref(
    props.products.map((product) => ({
        ...product,
        tempStock: product.stok, // Add temporary stock property
    }))
);

const orderItems = ref({});

// Computed property untuk total order
const orderTotal = computed(() => {
    return Object.values(orderItems.value).reduce((total, item) => {
        return total + item.price * item.quantity;
    }, 0);
});

// Add this computed property for total items
const totalItems = computed(() => {
    return Object.values(orderItems.value).reduce((total, item) => {
        return total + item.quantity;
    }, 0);
});

// Method untuk menambah item ke order
function addToOrder(product) {
    // Check if adding one more would exceed stock
    const currentQuantity = orderItems.value[product.id]?.quantity || 0;
    const productInList = productList.value.find((p) => p.id === product.id);

    if (productInList.tempStock <= 0) {
        alert("Stok produk habis!");
        return;
    }

    if (!orderItems.value[product.id]) {
        orderItems.value[product.id] = {
            id: product.id,
            name: product.nama,
            price: product.harga,
            quantity: 1,
            maxStock: product.stok,
        };
    } else {
        orderItems.value[product.id].quantity++;
    }

    // Decrease temporary stock
    productInList.tempStock--;
}

// Method untuk menghapus item dari order
function removeFromOrder(productId) {
    const item = orderItems.value[productId];
    const productInList = productList.value.find((p) => p.id === productId);

    // Restore temporary stock
    productInList.tempStock += item.quantity;

    delete orderItems.value[productId];
}

// Method untuk update quantity
function updateQuantity(productId, newQuantity) {
    const item = orderItems.value[productId];
    const productInList = productList.value.find((p) => p.id === productId);

    // Calculate the difference
    const difference = newQuantity - item.quantity;

    // Check if new quantity is valid
    if (productInList.tempStock - difference < 0) {
        alert("Stok tidak mencukupi!");
        return;
    }

    // Update temporary stock
    productInList.tempStock -= difference;

    // Update item quantity
    item.quantity = newQuantity;
}
</script>

<template>
    <Head title="Order Menu" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex gap-6">
                    <!-- Menu List (2/3 width) -->
                    <div
                        class="w-2/3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                    >
                        <h2 class="text-xl font-bold mb-4">Menu</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div
                                v-for="product in productList"
                                :key="product.id"
                                class="border p-4 rounded-lg cursor-pointer hover:bg-gray-50"
                                :class="{
                                    'opacity-50 cursor-not-allowed':
                                        product.tempStock <= 0,
                                }"
                                @click="
                                    product.tempStock > 0 && addToOrder(product)
                                "
                            >
                                <h3 class="font-bold">{{ product.nama }}</h3>
                                <p class="text-gray-600">
                                    Rp {{ product.harga.toLocaleString() }}
                                </p>
                                <p
                                    class="text-sm"
                                    :class="
                                        product.tempStock <= 3
                                            ? 'text-red-500'
                                            : 'text-gray-500'
                                    "
                                >
                                    Stok: {{ product.tempStock }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Preview (1/3 width) -->
                    <div
                        class="w-1/3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                    >
                        <h2 class="text-xl font-bold mb-4">Order Preview</h2>
                        <div
                            v-if="Object.keys(orderItems).length === 0"
                            class="text-gray-500"
                        >
                            Belum ada item yang dipilih
                        </div>
                        <div v-else>
                            <!-- Order Items -->
                            <div
                                v-for="item in orderItems"
                                :key="item.id"
                                class="flex flex-col mb-4 pb-4 border-b"
                            >
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium">
                                            {{ item.name }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            @ Rp
                                            {{ item.price.toLocaleString() }}
                                        </p>
                                    </div>
                                    <button
                                        @click="removeFromOrder(item.id)"
                                        class="text-red-500 hover:text-red-700"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"
                                            />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="flex items-center mt-2">
                                    <button
                                        @click="
                                            updateQuantity(
                                                item.id,
                                                Math.max(1, item.quantity - 1)
                                            )
                                        "
                                        class="px-2 py-1 bg-gray-200 rounded-l hover:bg-gray-300 transition"
                                    >
                                        -
                                    </button>
                                    <span class="px-4 py-1 bg-gray-100">{{
                                        item.quantity
                                    }}</span>
                                    <button
                                        @click="
                                            updateQuantity(
                                                item.id,
                                                Math.min(
                                                    item.maxStock,
                                                    item.quantity + 1
                                                )
                                            )
                                        "
                                        class="px-2 py-1 bg-gray-200 rounded-r hover:bg-gray-300 transition"
                                    >
                                        +
                                    </button>
                                    <span class="ml-2 text-sm text-gray-500">
                                        Subtotal: Rp
                                        {{
                                            (
                                                item.price * item.quantity
                                            ).toLocaleString()
                                        }}
                                    </span>
                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div class="border-t mt-4 pt-4">
                                <div
                                    class="flex justify-between text-sm text-gray-600 mb-2"
                                >
                                    <span>Total Items:</span>
                                    <span>{{ totalItems }}</span>
                                </div>
                                <div
                                    class="flex justify-between font-bold text-lg"
                                >
                                    <span>Total:</span>
                                    <span
                                        >Rp
                                        {{ orderTotal.toLocaleString() }}</span
                                    >
                                </div>
                                <button
                                    class="w-full mt-4 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition"
                                    :disabled="totalItems === 0"
                                >
                                    Proses Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
