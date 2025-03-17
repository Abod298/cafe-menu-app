<template>
    <div class="p-4 max-w-5xl mx-auto w-3/4">
        <h2 class="text-2xl font-bold mb-4">Permissions</h2>

        <!-- Search Input -->
        <Input type="text" v-model="searchQuery" placeholder="Arama yap..." class="mb-4" />

        <!-- Products Table -->
        <div class="overflow-x-auto">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Title</TableHead>
                        <TableHead class="flex justify-center">Actions</TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody v-if="filteredPermissions.length">
                    <TableRow v-for="(permission) in filteredPermissions" :key="permission.id">
                        <TableCell>{{ permission.id }}</TableCell>
                        <TableCell>{{ permission.title }}</TableCell>
                        <TableCell>
                            <div class="flex flex-col items-center">
                                <Button @click="handleEdit(permission.id)" variant="ghost"
                                    class="text-blue-600 hover:text-blue-900 mr-2">Edit</Button>
                                <Button @click="handleDelete(permission.id)" variant="ghost"
                                    class="text-red-600 hover:text-red-900">Delete</Button>
                            </div>

                        </TableCell>
                    </TableRow>
                </TableBody>

                <!-- No Data Message -->
                <TableBody v-else>
                    <TableRow>
                        <TableCell colspan="7" class="p-4 text-center text-gray-500">No Permissions</TableCell>
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

const props = defineProps({
    permissions: {
        type: Array,
        required: true,
    },
});

const searchQuery = ref("");


const filteredPermissions = computed(() => {
    if (!searchQuery.value) return props.permissions;

    const query = searchQuery.value.toLowerCase();

    return props.permissions.filter((permission) => {
        return Object.values(permission).some((value) => {
            if (typeof value === 'object' && value !== null) {
                return Object.values(value).some((nestedValue) =>
                    String(nestedValue).toLowerCase().includes(query)
                );
            }
            return String(value).toLowerCase().includes(query);
        });
    });
});

const handleEdit = (permissionId) => {
    router.get(route('permissions.edit', { permission: permissionId }));
};
const handleDelete =
    (permissionId) => confirm(` Are You Sure ?`)
        ? router.delete(route('permissions.destroy', { permission: permissionId }))
        : null;
</script>

<style>

</style>
