<script setup>
defineProps({
    heroTitle: String, // menerima prop heroTitle dari parent (Dashboard.vue)
});
</script>

<template>
    <section class="relative w-full min-h-[360px] flex flex-col text-white">
        <img loading="lazy" src="../../../public/hero.png" alt="Hero Image"
            class="absolute inset-0 w-full object-cover" />
        <div class="px-20 py-[132px] relative flex flex-col items-center bg-black bg-opacity-50">
            <h1 class="text-6xl font-bold uppercase tracking-[3px]">
                {{ heroTitle }}
            </h1>
        </div>
    </section>
</template>