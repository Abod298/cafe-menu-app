<template>
    <div class="p-6 max-w-5xl mx-auto">
      <h1 class="text-3xl font-bold mb-4 text-center">Role Details</h1>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Role Info Section -->
        <div class=" p-6 rounded-lg shadow-lg">
          <h2 class="text-xl font-semibold mb-2">Role Information</h2>
          <div class="space-y-4">
            <div class="flex justify-between">
              <span class="">Role Title:</span>
              <span class="font-medium">{{ role.title }}</span>
            </div>

            <div class="flex justify-between">
              <span class="">Permissions:</span>
              <div class="flex flex-wrap gap-2">
                <span
                  v-for="permission in role.permissions"
                  :key="permission.id"
                  class="px-3 py-1 bg-blue-500 text-xs rounded-lg">
                  {{ permission.title }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Actions Section -->
        <div class="p-6 rounded-lg shadow-lg flex flex-col space-y-4">
          <h2 class="text-xl font-semibold mb-2">Actions</h2>

          <Button
            @click="editRole" variant="ghost"
            class="text-blue-600 hover:text-blue-900 mr-2">
            Edit Role
          </Button>
          <Button
            @click="deleteRole" variant="ghost"
            class="text-red-600 hover:text-red-900">
            Delete Role
          </Button>
        </div>
      </div>

      <div class="mt-6">
        <h2 class="text-xl font-semibold mb-4">Assigned Permissions</h2>
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>Permission ID</TableHead>
              <TableHead>Permission Title</TableHead>
            </TableRow>
          </TableHeader>

          <TableBody>
            <TableRow v-for="permission in role.permissions" :key="permission.id">
              <TableCell>{{ permission.id }}</TableCell>
              <TableCell>{{ permission.title }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </template>

  <script setup>
  import { Button } from "@/components/ui/button";
  import { Table, TableHeader, TableRow, TableHead, TableBody, TableCell } from "@/components/ui/table";
  import { ref } from "vue";
  import { router } from "@inertiajs/vue3";
  import { route } from "ziggy-js";

  // Define the props passed from the parent (e.g., Role data)
  const props = defineProps({
    role: {
      type: Object,
      required: true,
    },
  });

  const editRole = () => {
    router.get(route("roles.edit", { role: props.role.id }));
  };

  const deleteRole = () => {
    if (confirm(`Are you sure you want to delete the role: ${props.role.title}?`)) {
      router.delete(route("roles.destroy", { role: props.role.id }));
    }
  };
  </script>

