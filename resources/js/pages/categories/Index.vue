<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import CardComponent from '@/components/CardComponent.vue';
import { Link } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: '/categories',
    },
];
defineProps(['categories']);
</script>

<template>

    <Head title="Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 items-center">
            <div>
                <Link :href="route('categories.create')"
                class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm
                font-semibold text-white shadow-xs hover:bg-indigo-500
                focus-visible:outline-2 focus-visible:outline-offset-2
                 focus-visible:outline-indigo-600">Katagori Ekle</Link>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6
                        min-h-screen
                        rounded-xl border border-sidebar-border/70
                        dark:border-sidebar-border">
                <CardComponent v-for="category in categories" :key="category.id" :category="category" />
            </div>
        </div>
    </AppLayout>
</template>
