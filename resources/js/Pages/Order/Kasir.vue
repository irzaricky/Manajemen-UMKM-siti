<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";

const props = defineProps({
    orderItems: Object,
    total: Number,
});

function goToCheckout() {
    router.post(route("order.invoice"), {
        items: props.orderItems,
    });
}
</script>

<template>
    <Head title="Kasir" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                >
                    <h2 class="text-xl font-bold mb-4">Kasir</h2>

                    <!-- List Produk -->
                    <div class="mb-4">
                        <div
                            v-for="item in orderItems"
                            :key="item.id"
                            class="flex justify-between items-center py-2 border-b"
                        >
                            <div>
                                <p class="font-medium">{{ item.name }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ item.quantity }}x @ Rp
                                    {{ item.price.toLocaleString() }}
                                </p>
                            </div>
                            <p class="font-medium">
                                Rp
                                {{
                                    (
                                        item.price * item.quantity
                                    ).toLocaleString()
                                }}
                            </p>
                        </div>
                    </div>

                    <!-- Total dan Tombol -->
                    <div
                        class="flex justify-between items-center mt-4 pt-4 border-t"
                    >
                        <Link
                            :href="route('order.index')"
                            preserve-state
                            preserve-scroll
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                        >
                            Kembali
                        </Link>
                        <div class="text-right">
                            <p class="text-xl font-bold mb-2">
                                Total: Rp {{ total.toLocaleString() }}
                            </p>
                            <button
                                @click="goToCheckout"
                                class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600"
                            >
                                Checkout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
