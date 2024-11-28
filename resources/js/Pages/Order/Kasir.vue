<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { ref } from 'vue';

const props = defineProps({
    orderItems: Object,
    total: Number,
});

function goToCheckout() {
    router.post(route("order.invoice"), {
        items: props.orderItems,
    });
}

// State untuk menyimpan pilihan pembayaran
const selectedPayment = ref("Choose Payment Method");
const isCashSelected = ref(false); // State untuk menandai apakah "Cash" dipilih
const cashAmount = ref(""); // State untuk nilai input
const changeAmount = ref(null); // State untuk kembalian

// Fungsi untuk mengubah pilihan pembayaran
const selectPaymentMethod = (method) => {
    selectedPayment.value = method;
    isCashSelected.value = method === "Cash"; // Tampilkan input jika "Cash"
    cashAmount.value = ""; // Reset input Cash
    changeAmount.value = null; // Reset Change
};

// Fungsi untuk memformat angka dengan titik setiap 3 digit
const formatCurrency = (value) => {
    const numericValue = value.replace(/\D/g, ""); // Hapus karakter non-digit
    return numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Tambahkan titik
};

// Fungsi untuk memperbarui nilai input dengan format
const handleInput = (event) => {
    const rawValue = event.target.value;
    cashAmount.value = formatCurrency(rawValue);
};

// Fungsi untuk menghitung kembalian
const handleEnter = () => {
    // Konversi subtotal dan cashAmount ke angka
    const subtotal = props.total; // Subtotal dari props
    const cash = parseInt(cashAmount.value.replace(/\./g, ""), 10) || 0;

    // Hitung kembalian
    if (cash >= subtotal) {
        changeAmount.value = formatCurrency((cash - subtotal).toString());
    } else {
        changeAmount.value = "0"; // Tidak ada kembalian jika kurang
    }
};
</script>

<template>

    <Head title="Kasir" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between">
                        <button
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 inline-flex items-center space-x-2">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="white" stroke-width="2" />
                                <path d="M5 19L19 5" stroke="white" stroke-width="2" />
                            </svg>
                            <span>Cancel</span>
                        </button>
                        <Link :href="route('order.index')" preserve-state preserve-scroll
                            class="bg-[#101916] text-white px-4 py-2 rounded hover:bg-gray-700">
                        + Add Item
                        </Link>
                    </div>

                    <hr class="md:mt-4 mt-3 w-full border border-solid bg-zinc-500 border-zinc-500 min-h-[2px] opacity-[0.32]"
                        aria-hidden="true" />

                    <!-- List Produk -->
                    <div class="mb-4 mt-4">
                        <table class="min-w-full divide-y divide-gray-200 border-b">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-base font-semibold">
                                        Product
                                    </th>
                                    <th class="px-4 py-2 text-center text-base font-semibold">
                                        Harga
                                    </th>
                                    <th class="px-4 py-2 text-center text-base font-semibold">
                                        QTY
                                    </th>
                                    <th class="px-4 py-2 text-center text-base font-semibold">
                                        Total
                                    </th>
                                    <th class="px-4 py-2 text-center text-base font-semibold">
                                        Remove
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="item in orderItems" :key="item.id">
                                    <td class="px-4 py-4 text-left text-base font-medium text-gray-600">
                                        {{ item.name }}
                                    </td>
                                    <td class="px-4 py-4 text-center text-base font-medium text-gray-600">
                                        Rp.{{ item.price.toLocaleString() }}
                                    </td>
                                    <td class="px-4 py-4 text-center text-base font-medium text-gray-600">
                                        {{ item.quantity }}
                                    </td>
                                    <td class="px-4 py-4 text-center text-base font-medium text-gray-600">
                                        Rp.{{ (item.price * item.quantity).toLocaleString() }}
                                    </td>
                                    <td class="px-4 py-4 text-center text-base font-medium text-gray-600 hover:text-red-600 cursor-pointer transition duration-100 ease-in-out">
                                        X
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Total dan Tombol -->
                    <div class="flex justify-center mt-24 w-full">
                        <div class="flex flex-col justify-start w-[45%]">
                            <p class="font-bold text-3xl tracking-[1px]">Total Bill</p>
                            <div class="border border-gray-700 border-opacity-20 p-4 mt-2 leading-9 rounded-sm">
                                <div class="font-semibold flex justify-between">
                                    <p>Subtotal</p>
                                    <p>Rp.{{ total.toLocaleString() }}</p>
                                </div>
                                <div class="font-semibold flex justify-between">
                                    <p>Payment Method</p>
                                    <div class="hidden sm:ms-6 sm:flex sm:items-center">
                                        <div class="relative">
                                            <Dropdown width="48">
                                                <template #trigger>
                                                    <span class="flex rounded-md">
                                                        <button
                                                            class="inline-flex items-center rounded-md border border-transparent bg-transparent text-sm font-semibold transition duration-150 ease-in-out hover:text-[#648374] focus:outline-none">
                                                            {{ selectedPayment }}
                                                            <svg class="ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </span>
                                                </template>
                                                <template #content>
                                                    <div class="py-2">
                                                        <a href="#" @click.prevent="selectPaymentMethod('Cash')"
                                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                            Cash
                                                        </a>
                                                        <a href="#" @click.prevent="selectPaymentMethod('QRIS')"
                                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                            QRIS
                                                        </a>
                                                    </div>
                                                </template>
                                            </Dropdown>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="isCashSelected" class="flex justify-between items-center">
                                    <p class="font-semibold">Cash</p>
                                    <div class="relative max-w-sm">
                                        <!-- Placeholder -->
                                        <span
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 pointer-events-none">
                                            Rp.
                                        </span>
                                        <!-- Input Field -->
                                        <input type="text"
                                            class="block rounded-md border border-gray-300 pl-10 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#648374]"
                                            placeholder="" :value="cashAmount" @input="handleInput"
                                            @keydown.enter="handleEnter" />
                                    </div>
                                </div>
                                <div v-if="changeAmount !== null" class="flex justify-between font-semibold mt-2">
                                    <p>Change</p>
                                    <p>Rp.{{ changeAmount }}</p>
                                </div>
                                <hr class="w-full mt-4 border border-solid bg-zinc-500 border-zinc-500 min-h-[0.5px] opacity-[0.32]"
                                    aria-hidden="true" />
                                <PrimaryButton @click="goToCheckout" class="mt-4 items-center flex justify-center">
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
