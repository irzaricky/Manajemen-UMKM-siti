<script setup>
import { ref } from "vue";

// Ambil data cart dari props atau route state
const props = defineProps({
    cart: Array,
});

// Hitung total harga
const totalHarga = ref(
    props.cart.reduce((total, item) => total + item.harga * item.quantity, 0)
);
</script>

<template>
    <div class="p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Halaman Checkout</h1>
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Detail Pesanan</h2>
            <div v-if="props.cart.length === 0" class="text-gray-500">
                Tidak ada item di keranjang.
            </div>
            <div v-else>
                <table class="w-full text-left border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border border-gray-300">Nama Produk</th>
                            <th class="p-2 border border-gray-300">Harga</th>
                            <th class="p-2 border border-gray-300">Jumlah</th>
                            <th class="p-2 border border-gray-300">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in props.cart"
                            :key="item.id"
                            class="border-t"
                        >
                            <td class="p-2 border border-gray-300">
                                {{ item.nama }}
                            </td>
                            <td class="p-2 border border-gray-300">
                                Rp {{ item.harga.toLocaleString() }}
                            </td>
                            <td class="p-2 border border-gray-300">
                                {{ item.quantity }}
                            </td>
                            <td class="p-2 border border-gray-300">
                                Rp
                                {{
                                    (item.harga * item.quantity).toLocaleString()
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="flex justify-between items-center mt-6">
                    <h3 class="text-lg font-semibold">Total:</h3>
                    <p class="text-lg font-bold">
                        Rp {{ totalHarga.toLocaleString() }}
                    </p>
                </div>
                <div class="mt-6">
                    <button
                        class="w-full bg-[#648374] hover:bg-[#355245] text-white font-bold py-3 rounded"
                    >
                        Konfirmasi dan Bayar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
/* Tambahkan CSS untuk styling tabel */
table {
    width: 100%;
    border-collapse: collapse;
}
th,
td {
    padding: 8px;
    text-align: left;
    border: 1px solid #ddd;
}
th {
    background-color: #f9fafb;
}
</style>
