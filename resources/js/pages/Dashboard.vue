<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Card, CardHeader, CardTitle, CardDescription, CardContent } from '@/components/ui/card';
import { Progress } from '@/components/ui/progress';
import { Button } from '@/components/ui/button';
import { Icon } from '@iconify/vue';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { BarChart } from '@/components/ui/chart-bar'
import { computed } from 'vue'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
const handleNewProduct = () => {
    router.get(route('products.create'));
};

const handleNewCategory = () => {
    router.get(route('categories.create'));
};

const handleRefresh = () => {
    window.location.reload();
};
defineProps<{
    visits: Record<string, number>
}>()


</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <!-- Visitor Count Card -->
                <Card class="flex flex-col justify-between">
                    <CardHeader>
                        <CardTitle class="text-lg">Toplam Ziyaretçi Sayısı</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="text-3xl font-bold">{{ visits.all }}</div>
                        <Progress :model-value="visits.all" class="mt-2" />
                    </CardContent>
                </Card>

                <!-- Recent Activity Card -->
                <Card>
                    <CardHeader>
                        <CardTitle class="text-lg">Bugünkü ziyaretçi sayısı</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <Icon icon="mdi:account" class="h-6 w-6 text-primary" />
                                <div>
                                    <p class="font-medium">{{ visits.thisDay }}</p>
                                    <p class="text-sm text-muted-foreground">Ziyaretçi</p>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>
                <!-- Quick Actions Card -->
                <Card>
                    <CardHeader>
                        <CardTitle class="text-lg">Hızlı İşlemler</CardTitle>
                        <CardDescription>Hızlıca işlem yapın</CardDescription>
                    </CardHeader>
                    <CardContent class="grid grid-cols-2 gap-4">
                        <Button @click="handleNewProduct" variant="outline" class="flex items-center gap-2">
                            <Icon icon="mdi:plus" class="h-4 w-4" />
                            Yeni Ürün
                        </Button>
                        <Button @click="handleNewCategory" variant="outline" class="flex items-center gap-2">
                            <Icon icon="mdi:plus" class="h-4 w-4" />
                            Yeni Kategori
                        </Button>
                        <Button @click="handleRefresh" variant="outline" class="flex items-center gap-2">
                            <Icon icon="mdi:refresh" class="h-4 w-4" />
                            Yenile
                        </Button>
                    </CardContent>
                </Card>
            </div>

            <Card class="flex-1">
                <CardHeader>
                    <CardTitle class="text-lg">Ziyaretçi Grafiği</CardTitle>
                    <CardDescription>Son 30 gün içindeki ziyaretçi sayısı</CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="relative aspect-video overflow-hidden rounded-xl ">
                        <BarChart
                        :colors="['#4CAF50']"
                        :data="visits.thisMonth"
                        index="name"
                        :categories="['total']"
                        :y-formatter="(tick: number) => new Intl.NumberFormat('en-US').format(tick)"
                        :x-formatter="(tick: string) => new Date(tick).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })" />
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
