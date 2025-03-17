<template>
    <div class="p-4 max-w-5xl mx-auto w-3/4">
        <h2 class="text-2xl font-bold mb-4">Users</h2>

        <!-- Search Input -->
        <Input type="text" v-model="searchQuery" placeholder="Arama yap..." class="mb-4" />

        <!-- Products Table -->
        <div class="overflow-x-auto">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Email</TableHead>
                        <TableHead>Roles</TableHead>
                        <TableHead class="flex justify-center">Actions</TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody v-if="filteredUsers.length">
                    <TableRow v-for="(user) in filteredUsers" :key="user.id">
                        <TableCell>{{ user.id }}</TableCell>
                        <TableCell>{{ user.name }}</TableCell>
                        <TableCell>{{ user.email }}</TableCell>
                        <TableCell>
                            <div class="flex flex-wrap gap-2">
                                <span v-for="role in user.roles" :key="role.id"
                                    class="px-2 py-1 bg-blue-500 text-white text-xs rounded-lg">
                                    {{ role.title }}
                                </span>
                            </div>
                        </TableCell>
                        <TableCell>
                            <div class="flex flex-col items-center">
                                <Button @click="handleDelete(user.id)" variant="ghost"
                                    class="text-red-600 hover:text-red-900">Delete</Button>
                            </div>

                        </TableCell>
                    </TableRow>
                </TableBody>

                <!-- No Data Message -->
                <TableBody v-else>
                    <TableRow>
                        <TableCell colspan="7" class="p-4 text-center text-gray-500">No Users</TableCell>
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
    users: {
        type: Array,
        required: true,
    },
});

const searchQuery = ref("");


const filteredUsers = computed(() => {
    if (!searchQuery.value) return props.users;

    const query = searchQuery.value.toLowerCase();

    return props.users.filter((user) => {
        return Object.values(user).some((value) => {
            if (typeof value === 'object' && value !== null) {
                return Object.values(value).some((nestedValue) =>
                    String(nestedValue).toLowerCase().includes(query)
                );
            }
            return String(value).toLowerCase().includes(query);
        });
    });
});

const handleDelete =
    (userId) => confirm(` Are You Sure ?`)
        ? router.delete(route('users.destroy', { user: userId }))
        : null;
</script>

<style>

</style>
