<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    orderItems: Object,
    total: Number,
});

// Updated cancelOrder function
const cancelOrder = () => {
    if (confirm("Are you sure you want to cancel this order?")) {
        // Clear backend session first without validation
        router.post(
            route("order.remove"),
            { clear_all: true }, // Add flag to clear all items
            {
                onSuccess: () => {
                    // Clear all client storage
                    sessionStorage.clear();
                    localStorage.removeItem("cart");
                    localStorage.removeItem("quantities");

                    // Redirect back to order page
                    router.get(route("order.index"));
                },
            }
        );
    }
};

// Updated removeItem function
const removeItem = (itemId) => {
    const updatedItems = Object.values(props.orderItems)
        .filter((item) => item.id !== itemId)
        .map((item) => ({
            id: item.id,
            nama: item.name,
            harga: item.price,
            quantity: item.quantity,
        }));

    // If cart becomes empty after removal
    if (updatedItems.length === 0) {
        // Use order.remove route to clear cart
        router.post(
            route("order.remove"),
            { product_id: itemId },
            {
                onSuccess: () => {
                    // Redirect to order page
                    router.get(route("order.index"));
                },
                onError: () => {
                    console.error("Failed to remove item");
                },
            }
        );
        return;
    }

    // Update cart with remaining items
    router.post(
        route("order.add"),
        { items: updatedItems },
        {
            preserveScroll: true,
            onError: () => {
                console.error("Failed to update cart");
            },
        }
    );
};

function goToCheckout() {
    router.post(route("order.invoice"), {
        items: props.orderItems,
    });
}

// Fungsi untuk memformat angka dengan titik setiap 3 digit
const formatCurrency = (value) => {
    const numericValue = value.replace(/\D/g, "");
    return numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};
</script>

<template>
    <Head title="Kasir" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                >
                    <div class="flex justify-between">
                        <button
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 inline-flex items-center space-x-2"
                            @click="cancelOrder"
                        >
                            <svg
                                width="16"
                                height="16"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="white"
                                    stroke-width="2"
                                />
                                <path
                                    d="M5 19L19 5"
                                    stroke="white"
                                    stroke-width="2"
                                />
                            </svg>
                            <span>Cancel</span>
                        </button>
                        <Link
                            :href="route('order.index')"
                            preserve-state
                            preserve-scroll
                            class="bg-[#101916] text-white px-4 py-2 rounded hover:bg-gray-700"
                        >
                            + Add Item
                        </Link>
                    </div>

                    <hr
                        class="md:mt-4 mt-3 w-full border border-solid bg-zinc-500 border-zinc-500 min-h-[2px] opacity-[0.32]"
                        aria-hidden="true"
                    />

                    <!-- List Produk -->
                    <div class="mb-4 mt-4">
                        <table
                            class="min-w-full divide-y divide-gray-200 border-b"
                        >
                            <thead>
                                <tr>
                                    <th
                                        class="px-4 py-2 text-left text-base font-semibold"
                                    >
                                        Product
                                    </th>
                                    <th
                                        class="px-4 py-2 text-center text-base font-semibold"
                                    >
                                        Harga
                                    </th>
                                    <th
                                        class="px-4 py-2 text-center text-base font-semibold"
                                    >
                                        QTY
                                    </th>
                                    <th
                                        class="px-4 py-2 text-center text-base font-semibold"
                                    >
                                        Total
                                    </th>
                                    <th
                                        class="px-4 py-2 text-center text-base font-semibold"
                                    >
                                        Remove
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="item in orderItems" :key="item.id">
                                    <td
                                        class="px-4 py-4 text-left text-base font-medium text-gray-600"
                                    >
                                        {{ item.name }}
                                    </td>
                                    <td
                                        class="px-4 py-4 text-center text-base font-medium text-gray-600"
                                    >
                                        Rp.{{ item.price.toLocaleString() }}
                                    </td>
                                    <td
                                        class="px-4 py-4 text-center text-base font-medium text-gray-600"
                                    >
                                        {{ item.quantity }}
                                    </td>
                                    <td
                                        class="px-4 py-4 text-center text-base font-medium text-gray-600"
                                    >
                                        Rp.{{
                                            (
                                                item.price * item.quantity
                                            ).toLocaleString()
                                        }}
                                    </td>
                                    <td
                                        class="px-4 py-4 text-center text-base font-medium text-gray-600 hover:text-red-600 cursor-pointer transition duration-100 ease-in-out"
                                        @click="removeItem(item.id)"
                                    >
                                        X
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Total dan Tombol -->
                    <div class="flex justify-center mt-24 w-full">
                        <div class="flex flex-col justify-start w-[45%]">
                            <p class="font-bold text-3xl tracking-[1px]">
                                Total Bill
                            </p>
                            <div
                                class="border border-gray-700 border-opacity-20 p-4 mt-2 leading-9 rounded-sm"
                            >
                                <div class="font-semibold flex justify-between">
                                    <p>Subtotal</p>
                                    <p>Rp.{{ total.toLocaleString() }}</p>
                                </div>
                                <div class="font-semibold flex justify-between">
                                    <p>Payment Method</p>
                                    <div
                                        class="hidden sm:ms-6 sm:flex sm:items-center"
                                    >
                                        <div class="relative">
                                            <span>CASH</span>
                                        </div>
                                    </div>
                                </div>
                                <hr
                                    class="w-full mt-4 border border-solid bg-zinc-500 border-zinc-500 min-h-[0.5px] opacity-[0.32]"
                                    aria-hidden="true"
                                />
                                <PrimaryButton
                                    @click="goToCheckout"
                                    class="mt-4 items-center flex justify-center"
                                >
                                    Checkout
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
