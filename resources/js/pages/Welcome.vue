<template>
    <div class="min-h-screen p-6 flex flex-col items-center">
        <h1 class="text-3xl font-bold mb-6">Menü {{ visitCount }}</h1>
        <div class="w-full max-w-3xl">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">

                <button v-for="category in props.categories" :key="category.id"
                    class="bg-white shadow-md p-4 rounded-lg text-center font-semibold text-gray-700 hover:bg-blue-500 hover:text-white transition"
                    @click="openDialog(category)">
                    <div class="relative">
                        <swiper v-if="category.images.length" :modules="[Autoplay]" :slides-per-view="1"
                            :autoplay="{ delay: 2500, disableOnInteraction: false }" class="rounded-lg overflow-hidden">
                            <swiper-slide v-for="(image, index) in category.images" :key="index">
                                <img :src="image" :alt="category.name" class="w-full h-auto object-cover" />
                            </swiper-slide>
                        </swiper>
                        <PlaceholderPattern v-else />
                    </div>
                    {{ category.name }}
                    <p>{{ category.description }}</p>
                    <p>{{ category.products_count }} Ürün !</p>
                </button>

            </div>
            <ProductsDialog v-if="isDialogOpen"
            :category="selectedCategory"
            :isDialogOpen="isDialogOpen"
            @close-products-dialog="isDialogOpen = false"
            />

        </div>
    </div>
</template>

<script setup>
import ProductsDialog from "@/components/ProductsDialog.vue";
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Navigation } from 'swiper/modules';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import 'swiper/css';
import 'swiper/css/navigation';
import { ref } from "vue";

const props = defineProps({
    categories: Object,
    visitCount:Number,
});


const selectedCategory = ref(null);

const isDialogOpen = ref(false);

const openDialog = (category) => {
    selectedCategory.value = category;
    isDialogOpen.value = true;
};
</script>

