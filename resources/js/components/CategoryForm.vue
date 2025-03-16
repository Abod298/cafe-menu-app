<template>
    <form @submit.prevent="submitForm" class="space-y-6 max-w-xl mx-auto mt-3">
        <h2 class="text-2xl font-bold">Kategori {{ isEdit ? 'Düzenle' : ' Ekle' }}</h2>

        <div>
            <label for="name" class="block text-sm font-medium">Category Name</label>
            <Input id="name" v-model="form.name" placeholder="Enter category name" required />
            <p v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</p>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium">Description</label>
            <Textarea id="description" v-model="form.description" placeholder="Enter category description"></Textarea>
            <p v-if="errors.description" class="text-red-500 text-sm mt-1">{{ errors.description }}</p>
        </div>

        <div class="flex items-center space-x-2">
            <Checkbox id="is_active" v-model:checked="form.is_active" />
            <label for="is_active" class="text-sm font-medium">Satışta</label>
            <p v-if="errors.is_active" class="text-sm text-red-500">{{ errors.is_active }}</p>
        </div>

        <div class="border-2 border-dashed rounded-xl p-6 text-center cursor-pointer" @dragover.prevent
            @drop.prevent="handleDrop" @click="triggerFileInput">
            <p class="text-gray-600">Drag and drop images here or click to upload</p>
            <input type="file" multiple ref="fileInput" @change="handleFileChange" accept="image/*" hidden />
        </div>
        <p class="text-sm text-gray-500 mt-2">
            Eğer resimleri değiştirmek istemiyorsanız, bu alanı boş bırakın. Yeni bir resim yüklerseniz, eski resimler
            silinecektir.
        </p>


        <div v-if="form.images.length" class="mt-4 grid grid-cols-3 gap-4">
            <div v-for="(image, index) in form.images" :key="index" class="relative">
                <img :src="image.preview" alt="Uploaded Image" class="w-full h-32 object-cover rounded-lg" />
                <button type="button" @click="removeImage(index)"
                    class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full text-xs">
                    ✕
                </button>
            </div>
        </div>

        <Button type="submit" class="w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm
                font-semibold text-white shadow-xs hover:bg-indigo-500
                focus-visible:outline-2 focus-visible:outline-offset-2
                 focus-visible:outline-indigo-600 ">Kategori {{ isEdit ? ' Güncelle' : 'Ekle' }}</Button>
    </form>
</template>

<script setup>
import { ref } from "vue";
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js';
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Textarea } from "@/components/ui/textarea";
import { Checkbox } from '@/components/ui/checkbox';

import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    category: {
        type: Object,
        default: () => ({}),
    },
    isEdit: {
        type: Boolean,
        default: false,
    },
});

const form = ref({
    name: props.category.name ? props.category.name : '',
    description: props.category.description ? props.category.description : '',
    is_active: props.category.is_active ? props.category.is_active : true,
    images: [],
});


const { errors } = usePage().props;

const fileInput = ref(null);

const handleDrop = (event) => {
    const files = Array.from(event.dataTransfer.files);
    processFiles(files);
};

const handleFileChange = (event) => {
    const files = Array.from(event.target.files);
    processFiles(files);
};

const processFiles = (files) => {
    files.forEach((file) => {
        if (file.type.startsWith("image/")) {
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

const triggerFileInput = () => {
    fileInput.value.click();
};

const removeImage = (index) => {
    form.value.images.splice(index, 1);
};

const submitForm = () => {
    props.isEdit ? updateCategory() : createCategory();
};

const updateCategory = () => {
    router.post(route('categories.update', { category: props.category.id }), {
        _method: 'PUT',
        ...form.value,
    }, {
        onError: (newErrors) => {
            errors.value = newErrors;
        },
    });
};

const createCategory = () => {
    router.post(route('categories.store'), form.value, {
        onError: (newErrors) => {
            errors.value = newErrors;
        },
    });
};

</script>
