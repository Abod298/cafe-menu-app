<template>
    <form @submit.prevent="submitForm" class="space-y-6 max-w-xl mx-auto mt-8">
        <h2 class="text-3xl font-bold mb-6 text-center">Ürün {{ isEdit ? 'Düzenle' : 'Ekle' }}</h2>

        <!-- Ürün Adı -->
        <div>
            <label for="name" class="block text-sm font-medium">Ürün Adı</label>
            <Input id="name" name="name" v-model="form.name" placeholder="Ürün adını girin" required />
            <p v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</p>
        </div>

        <!-- Açıklama -->
        <div>
            <label for="description" class="block text-sm font-medium">Açıklama</label>
            <Textarea name="description" v-model="form.description" id="description"
                placeholder="Ürün açıklamasını girin" rows="4" />
            <p v-if="errors.description" class="text-red-500 text-sm mt-1">{{ errors.description }}</p>
        </div>

        <!-- Fiyat -->
        <div>
            <label for="price" class="block text-sm font-medium">Fiyat (₺)</label>
            <Input name="price" v-model="form.price" id="price" type="number" placeholder="Ürün fiyatını girin"
                required />
            <p v-if="errors.price" class="text-red-500 text-sm mt-1">{{ errors.price }}</p>
        </div>
        <div class="flex items-center space-x-2">
            <Checkbox id="is_active" v-model:checked="form.is_active" />
            <label for="is_active" class="text-sm font-medium">Satışta</label>
            <p v-if="errors.is_active" class="text-sm text-red-500">{{ errors.is_active }}</p>
        </div>

        <!-- Kategori Seçimi -->
        <div>
            <label for="category" class="block text-sm font-medium">Kategori</label>
            <Select name="category_id" v-model="form.category_id">
                <SelectTrigger class="w-[180px]">
                    <SelectValue placeholder="Bağlı Kategori" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectLabel>Kategori</SelectLabel>
                        <SelectItem v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
            <p v-if="errors.category_id" class="text-red-500 text-sm mt-1">{{ errors.category_id }}</p>
        </div>

        <!-- Görsel Yükleme -->
        <div class="border-2 border-dashed rounded-xl p-6 text-center cursor-pointer" @dragover.prevent
            @drop.prevent="handleDrop" @click="triggerFileInput">
            <p class="text-gray-600">Resimleri buraya sürükleyin veya tıklayarak yükleyin</p>
            <input type="file" multiple ref="fileInput" @change="handleFileChange" accept="image/*" hidden />
        </div>
        <p class="text-sm text-gray-500 mt-2">Yeni bir resim yüklerseniz, mevcut resimler silinecektir.</p>

        <div v-if="form.images.length" class="mt-4 grid grid-cols-3 gap-4">
            <div v-for="(image, index) in form.images" :key="index" class="relative">
                <img :src="image.preview" alt="Uploaded Image" class="w-full h-32 object-cover rounded-lg" />
                <button type="button" @click="removeImage(index)"
                    class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full text-xs">✕</button>
            </div>
        </div>

        <p v-if="errors.images" class="text-red-500 text-sm mt-1">{{ errors.images }}</p>

        <!-- Gönder Butonu -->
        <Button type="submit"
            class="w-full rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-indigo-500">
            Ürünü {{ isEdit ? 'Güncelle' : 'Ekle' }}
        </Button>
    </form>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Button } from '@/components/ui/button';

import { Checkbox } from '@/components/ui/checkbox';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    product: {
        type: Object,
        required: false,
    },
    categories: {
        type: Array,
        required: true,
    },
    isEdit: {
        type: Boolean,
        default: false,
    },
});

const form = ref({
    name: props.product ? props.product.name : '',
    description: props.product ? props.product.description : '',
    price: props.product ? props.product.price : '',
    is_active: props.product ? props.product.is_active : true,
    category_id: props.product ? props.product.category_id : '',
    images: [],
});

const { errors } = usePage().props;

const fileInput = ref(null);

// Handle Drag-and-Drop Images
const handleDrop = (event) => {
    const files = Array.from(event.dataTransfer.files);
    processFiles(files);
};

// Handle Manual File Selection
const handleFileChange = (event) => {
    const files = Array.from(event.target.files);
    processFiles(files);
};

// Process Files and Create Preview
const processFiles = (files) => {
    files.forEach((file) => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = () => {
                form.value.images.push({
                    file,
                    preview: reader.result,
                });
            };
            reader.readAsDataURL(file);
        }
    });
};

// Trigger File Input
const triggerFileInput = () => {
    fileInput.value.click();
};

// Remove Image
const removeImage = (index) => {
    form.value.images.splice(index, 1);
};

const submitForm = () => {
    props.isEdit ? updateProduct() : createProduct();
};

const updateProduct = () => {
    router.post(route('products.update', { product: props.product.id }), {
        _method: 'PUT',
        ...form.value,
    }, {
        onError: (newErrors) => {
            errors.value = newErrors;
        },
    });
};

const createProduct = () => {
    router.post(route('products.store'), form.value, {
        onError: (newErrors) => {
            errors.value = newErrors;
        },
    });
};
</script>

