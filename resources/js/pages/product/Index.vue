<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import ProductsTable from '@/components/ProductsTable.vue';
import { Link } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '/products',
    },
];
const props = defineProps([
    'products',
]);
</script>

<template>
    <Head title="Products" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div>
                <Link :href="route('products.create')"
                class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm
                font-semibold text-white shadow-xs hover:bg-indigo-500
                focus-visible:outline-2 focus-visible:outline-offset-2
                 focus-visible:outline-indigo-600">Ürün Ekle</Link>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <ProductsTable :products="products" />
            </div>
        </div>
    </AppLayout>
</template>
