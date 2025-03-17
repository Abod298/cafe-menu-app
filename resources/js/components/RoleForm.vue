<template>
    <form @submit.prevent="submitForm" class="space-y-6 max-w-xl mx-auto mt-8">
        <h2 class="text-3xl font-bold mb-6 text-center">Role {{ isEdit ? 'Update' : 'Create' }}</h2>
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Title</label>
            <Input type="text" id="name" v-model="form.title"
                class="mt-1 block
                    w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
        </div>
        <div>
            <label for="permissions" class="block font-medium mt-4 mb-2">Permissions</label>
            <select id="permissions" v-model="form.permissions" multiple
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-300">
                <option v-for="permission in permissions" :key="permission.id" :value="permission.id"
                :selected="form.permissions.includes(permission.id)">
                    {{ permission.title }}
                </option>
            </select>
        </div>
        <Button type="submit"
            class="w-full rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-indigo-500">
            Role {{ isEdit ? 'Update' : 'Create' }}
        </Button>
    </form>
</template>

<script setup>
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { ref, computed } from 'vue';

const props = defineProps({
    role: {
        type: Object,
        required: false,
        default: () => ({}),
    },
    permissions: {
        type: Array,
        required: true,
    },
    isEdit: {
        type: Boolean,
        default: false,
    },
});

// Form Data
const form = ref({
    title: props.role?.title || '',
    permissions: props.role.permissions ? props.role.permissions.map(p => p.id) : [],
});


const submitForm = () => {
    props.isEdit ? updateRole() : createRole();
};

// Create Role
const createRole = () => {
    router.post(route('roles.store'), form.value, {
        onError: (newErrors) => {
            console.error(newErrors);
        },
    });
};

// Update Role
const updateRole = () => {
    router.put(route('roles.update', { role: props.role.id }), form.value, {
        onError: (newErrors) => {
            console.error(newErrors);
        },
    });
};
</script>

<style></style>
