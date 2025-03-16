<template>
    <div class="p-4 max-w-5xl mx-auto">
        <h2 class="text-2xl font-bold mb-4">Products</h2>

        <!-- Search Input -->
        <Input type="text" v-model="searchQuery" placeholder="Arama yap..." class="mb-4" />

        <!-- Products Table -->
        <div class="overflow-x-auto">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Ürün Adı</TableHead>
                        <TableHead>Açıklama</TableHead>
                        <TableHead>Kategori</TableHead>
                        <TableHead>Fiyat</TableHead>
                        <TableHead>Aktif</TableHead>
                        <TableHead>Image</TableHead>
                        <TableHead>Actions</TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody v-if="filteredProducts.length">
                    <TableRow v-for="(product) in filteredProducts" :key="product.id">
                        <TableCell>{{ product.id }}</TableCell>
                        <TableCell>{{ product.name }}</TableCell>
                        <TableCell>{{ product.description }}</TableCell>
                        <TableCell>{{ product.category || 'N/A' }}</TableCell>
                        <TableCell>{{ product.price }} ₺</TableCell>
                        <TableCell>
                            <span :class="product.is_active ? 'text-green-500' : 'text-red-500'">
                                {{ product.is_active ? 'Evet' : 'Hayır' }}
                            </span>
                        </TableCell>
                        <TableCell>
                            <swiper v-if="product.images.length" class="swiper-container-small" :modules="[Autoplay]"
                                :dublicate="true" :slides-per-view="1"
                                :autoplay="{ delay: 2500, disableOnInteraction: false }">
                                <swiper-slide v-for="(image, index) in product.images" :key="index">
                                    <img :src="image" alt="Product Image" class="w-full h-auto rounded-lg" />
                                </swiper-slide>
                            </swiper>
                            <div v-else class="flex justify-center items-center">
                                <p>Resim Yok</p>
                            </div>

                        </TableCell>
                        <TableCell>
                            <div class="flex flex-col items-center">
                                <Button @click="handleShow(product.id)" variant="ghost"
                                    class="text-green-600 hover:text-green-900 mr-2">Göster</Button>
                                <Button @click="handleEdit(product.id)" variant="ghost"
                                    class="text-blue-600 hover:text-blue-900 mr-2">Düzenle</Button>
                                <Button @click="handleDelete(product.id)" variant="ghost"
                                    class="text-red-600 hover:text-red-900">Sil</Button>
                            </div>

                        </TableCell>
                    </TableRow>
                </TableBody>

                <!-- No Data Message -->
                <TableBody v-else>
                    <TableRow>
                        <TableCell colspan="7" class="p-4 text-center text-gray-500">Ürün Yok !</TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </div>
</template>
<script setup>
import { ref, computed } from 'vue';
import { Table, TableHeader, TableRow, TableHead, TableBody, TableCell, } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Navigation } from 'swiper/modules';
import 'swiper/css';

const props = defineProps({
    products: {
        type: Array,
        required: true,
    },
});

const searchQuery = ref("");

// Filter products based on the search query
const filteredProducts = computed(() => {
    if (!searchQuery.value) return props.products;

    const query = searchQuery.value.toLowerCase();

    return props.products.filter((product) => {
        return Object.values(product).some((value) => {
            if (typeof value === 'object' && value !== null) {
                // Search within nested objects (e.g., category.name)
                return Object.values(value).some((nestedValue) =>
                    String(nestedValue).toLowerCase().includes(query)
                );
            }
            return String(value).toLowerCase().includes(query);
        });
    });
});
const handleShow = (productId) => {
    router.get(route('products.show', { product: productId }));
};
const handleEdit = (productId) => {
    router.get(route('products.edit', { product: productId }));
};
const handleDelete =
    (productId) => confirm(` ${props.name} Ürün Silinecek . Emin misiniz?`)
        ? router.delete(route('products.destroy', { product: productId }))
        : null;
</script>
<style scoped>
.swiper-container-small {
    width: 150px;
    height: 100px;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
