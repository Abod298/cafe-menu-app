<template>
    <div class="p-4 max-w-5xl mx-auto w-3/4">
        <h2 class="text-2xl font-bold mb-4">Roles</h2>

        <!-- Search Input -->
        <Input type="text" v-model="searchQuery" placeholder="Arama yap..." class="mb-4" />

        <!-- Products Table -->
        <div class="overflow-x-auto">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Title</TableHead>
                        <TableHead>Permissions</TableHead>
                        <TableHead class="flex justify-center items-center">Actions</TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody v-if="filteredRoles.length">
                    <TableRow v-for="(role) in filteredRoles" :key="role.id">
                        <TableCell>{{ role.id }}</TableCell>
                        <TableCell>{{ role.title }}</TableCell>
                        <TableCell>
                            <div class="flex flex-wrap gap-2">
                                <span v-for="permission in role.permissions" :key="permission.id"
                                    class="px-2 py-1 bg-blue-500 text-white text-xs rounded-lg">
                                    {{ permission.title }}
                                </span>
                            </div>
                        </TableCell>
                        <TableCell>
                            <div class="flex flex-col items-center">
                                <Button @click="handleShow(role.id)" variant="ghost"
                                    class="text-green-600 hover:text-green-900 mr-2">Show</Button>
                                <Button @click="handleEdit(role.id)" variant="ghost"
                                    class="text-blue-600 hover:text-blue-900 mr-2">Edit</Button>
                                <Button @click="handleDelete(role.id)" variant="ghost"
                                    class="text-red-600 hover:text-red-900">Delete</Button>
                            </div>
                        </TableCell>
                    </TableRow>
                </TableBody>

                <!-- No Data Message -->
                <TableBody v-else>
                    <TableRow>
                        <TableCell colspan="7" class="p-4 text-center text-gray-500">No Roles</TableCell>
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
    roles: {
        type: Array,
        required: true,
    }
});


const searchQuery = ref("");

const filteredRoles = computed(() => {
    if (!searchQuery.value) return props.roles;

    const query = searchQuery.value.toLowerCase();

    return props.roles.filter((role) => {
        return (
            role.title.toLowerCase().includes(query) ||
            role.permissions.some((permission) =>
                permission.title.toLowerCase().includes(query)
            )
        );
    });
});
const handleShow = (roleID) => {
    router.get(route('roles.show', { role: roleID }));
};
const handleEdit = (roleID) => {
    router.get(route('roles.edit', { role: roleID }));
};
const handleDelete =
    (roleID) => confirm(` ${props.title} Ürün Silinecek . Emin misiniz?`)
        ? router.delete(route('roles.destroy', { role: roleID }))
        : null;

</script>

<style></style>
