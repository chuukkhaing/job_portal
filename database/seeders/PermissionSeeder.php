<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'state-list',
            'state-create',
            'state-edit',
            'state-delete',
            'township-list',
            'township-create',
            'township-edit',
            'township-delete',
            'industry-list',
            'industry-create',
            'industry-edit',
            'industry-delete',
            'ownership-type-list',
            'ownership-type-create',
            'ownership-type-edit',
            'ownership-type-delete',
            'skill-list',
            'skill-create',
            'skill-edit',
            'skill-delete',
            'main-funcational-area-list',
            'main-funcational-area-create',
            'main-funcational-area-edit',
            'main-funcational-area-delete',
            'sub-functional-area-list',
            'sub-functional-area-create',
            'sub-functional-area-edit',
            'sub-functional-area-delete',
            'package-item-list',
            'package-item-create',
            'package-item-edit',
            'package-item-delete',
            'package-type-list',
            'package-type-create',
            'package-type-edit',
            'package-type-delete',
            'employer-list',
            'employer-create',
            'employer-edit',
            'employer-delete',
            'slider-list',
            'slider-create',
            'slider-edit',
            'slider-delete',
            'seeker-employer-contact-list',
         ];
      
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
