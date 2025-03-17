<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_management_access',
            ],
            [
                'id'    => 3,
                'title' => 'role_management_access',
            ],
            [
                'id'    => 4,
                'title' => 'category_management_access',
            ],
            [
                'id'    => 5,
                'title' => 'product_management_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
