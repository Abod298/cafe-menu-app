<template>
    <Dialog v-model:open="props.isDialogOpen">
        <DialogContent class="max-w-lg w-full bg-white p-6 rounded-lg shadow-lg max-h-[90vh] text-gray-600">
            <DialogTitle class="text-2xl font-semibold mb-4">
                {{ props.category?.name }}
            </DialogTitle>

            <div class="overflow-y-auto max-h-[60vh] pr-2">
                <ul class="space-y-4">
                    <li v-for="product in props.category?.products" :key="product.id"
                        class="flex items-center gap-4 py-2 border-b border-gray-200 last:border-b-0">
                        <!-- Image container with fixed dimensions -->
                        <div class="relative w-24 h-24 flex-shrink-0">
                            <swiper v-if="product.images && product.images.length" :modules="[Autoplay]"
                                :slides-per-view="1" :autoplay="{ delay: 2500, disableOnInteraction: false }"
                                class="w-full h-full rounded-lg overflow-hidden">
                                <swiper-slide v-for="(image, index) in product.images" :key="index">
                                    <img :src="image" :alt="product.name" class="w-full h-full object-cover" />
                                </swiper-slide>
                            </swiper>
                            <PlaceholderPattern v-else class="w-full h-full" />
                        </div>

                        <!-- Product details -->
                        <div class="min-w-0">
                            <span class="font-medium block">{{ product.name }}</span>
                            <span><p>{{ product.description }}</p></span>
                            <span>{{ product.price }} TL</span>
                        </div>
                    </li>
                </ul>
            </div>

            <DialogFooter class="mt-4">
                <DialogClose v-on:click="closeDialog"
                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                    Kapat
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<script setup>
import { Dialog, DialogContent, DialogTitle, DialogClose, DialogFooter } from "@/components/ui/dialog";
import { ref } from "vue";
import { defineEmits } from "vue";
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Navigation } from 'swiper/modules';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import 'swiper/css';
import 'swiper/css/navigation';


const props = defineProps({
    category: Object,
    isDialogOpen: Boolean
});

const emit = defineEmits(["close-products-dialog"]);
const closeDialog = () => {
    emit("close-products-dialog");
};
</script>
