<template>
    <div class="container mx-auto p-6" >
        <!-- Product Card -->
        <Card>
            <CardContent>
                <div class="grid grid-cols-1 items-center md:grid-cols-2 gap-8 mt-4">

                    <!-- Image Slider -->
                    <div class="relative">
                        <swiper v-if="images.length" :modules="[Autoplay]" :slides-per-view="1"
                            :autoplay="{ delay: 2500, disableOnInteraction: false }" class="rounded-lg overflow-hidden">
                            <swiper-slide v-for="(image, index) in images" :key="index">
                                <img :src="image" :alt="product.name" class="w-full h-96 object-cover" />
                            </swiper-slide>
                        </swiper>
                        <PlaceholderPattern v-else />
                    </div>

                    <!-- Product Details -->
                    <div class="space-y-6">
                        <h1 class="text-3xl font-bold">{{ product.name }}</h1>
                        <p class="text-lg ">{{ product.description }}</p>

                        <div class="text-2xl font-semibold">{{ formatPrice(product.price) }} ₺</div>

                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Kategori: {{ product.category.name }}
                        </div>

                        <Link class="text-blue-600 hover:text-blue-900 bg-blue-200 hover:bg-blue-300 transition-colors
                         font-semibold mt-5 px-4 py-2 rounded-lg shadow-md w-full justify-center flex items-center"
                            :href="route('products.edit', props.product.id)" id="edit">Düzenle</Link>

                    </div>

                </div>
            </CardContent>
        </Card>
    </div>
</template>

<script setup>
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Navigation } from 'swiper/modules';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { Link } from '@inertiajs/vue3';
import 'swiper/css';
import 'swiper/css/navigation';

// Props for product data
const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    images: {
        type: Array,
        required: false,
    },
});

// Format price helper
const formatPrice = (price) => new Intl.NumberFormat('tr-TR').format(price);
</script>
