<template>
    <Card class="w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg mt-4  shadow-lg rounded-2xl overflow-hidden">
        <CardHeader class="relative">
            <div class="absolute top-0 right-0 bg-blue-500 text-white px-3 py-1 rounded-lg text-sm m-2 z-10">
                {{ category.products_count }} Ürün
            </div>
            <!-- Image Slider -->
            <div class="relative w-full h-36 sm:h-48 md:h-56 lg:h-64 overflow-hidden rounded-lg">
                <swiper
                v-if="category.images.length"
                :modules="[Autoplay]"
                :dublicate="true"
                :slides-per-view="1"
                :autoplay="{ delay: 2500, disableOnInteraction: false }">
                    <swiper-slide v-for="(image, index) in category.images" :key="index">
                        <img :src="image" :alt="category.name" class="w-full h-full object-cover" />
                    </swiper-slide>
                </swiper>
                <PlaceholderPattern v-else />
            </div>

        </CardHeader>

        <CardContent class="">
            <h2 class="text-xl md:text-2xl font-semibold">{{ category.name }}</h2>
            <p class=" mt-2 text-sm md:text-base">{{ category.description }}</p>
            <p :class="category.is_active ? 'text-green-500' : 'text-red-500'">
                {{ category.is_active ? 'Aktif' : 'Aktif Değil !' }}
            </p>

            <div class="mt-4 flex justify-between">
                <Button @click="handleShow" variant="ghost" class="text-green-600 hover:text-green-900 mr-2">
                    Göster
                </Button>
                <Button @click="handleEdit" variant="ghost" class="text-blue-600 hover:text-blue-900 mr-2">
                    Düzenle
                </Button>
                <Button @click="handleDelete" variant="ghost" class="text-red-600 hover:text-red-900">
                    Sil
                </Button>
            </div>

        </CardContent>
    </Card>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { Card, CardHeader, CardContent } from "@/components/ui/card";
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Navigation } from 'swiper/modules';
import 'swiper/css';
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

// Props
const props = defineProps({
    category: {
        type: Object,
        required: true,
    },
});

const handleShow = () => {
    router.get(route('categories.show', {category : props.category.id}));
};

const handleEdit = () => {
    router.get(route('categories.edit' , {category : props.category.id}) );
};

const handleDelete = () => confirm(` ${props.name} Kategori ve Bütün Bağlı Ürünler Silinecek . Emin misiniz?`)
    ? router.delete(route('categories.destroy', { category: props.category.id }))
    : null;

</script>

<style scoped>
/* Smooth sliding transition */
.flex {
    display: flex;
}
</style>
