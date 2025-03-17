<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import RoleForm from '@/components/RoleForm.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Roled',
        href: '/roles',
    },
];
defineProps([
    'permissions'
]);
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <RoleForm :permissions="permissions"/>
        </div>
    </AppLayout>
</template>
