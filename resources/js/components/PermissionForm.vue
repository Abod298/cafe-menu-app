<template>
    <form @submit.prevent="submitForm" class="space-y-6 max-w-xl mx-auto mt-8">
        <h2 class="text-3xl font-bold mb-6 text-center">Permission {{ isEdit ? 'Update' : 'Create' }}</h2>
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Title</label>
            <Input type="text" id="name" v-model="form.title"
                class="mt-1 block
                    w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                </div>
        <Button type="submit"
            class="w-full rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-indigo-500">
            Permission {{ isEdit ? 'Update' : 'Create' }}
        </Button>
    </form>
</template>

<script setup>
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { ref } from 'vue';
const props = defineProps({
    permission: {
        type: Object,
        required: false,
    },
    isEdit: {
        type: Boolean,
        default: false,
    },
});
const form = ref({
    title: props.permission ? props.permission.title : '',
});
const submitForm = () => {
    props.isEdit ? updatePermisson() : createPermission();
};

const createPermission = () => {
    router.post(route('permissions.store'), form.value, {
        onError: (newErrors) => {
            errors.value = newErrors;
        },
    });
};
const updatePermisson = () => {
    router.post(route('permissions.update', { permission: props.permission.id }), {
        _method: 'PUT',
        ...form.value,
    }, {
        onError: (newErrors) => {
            errors.value = newErrors;
        },
    });
};
</script>

<style></style>
