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
            'main-functional-area-list',
            'main-functional-area-create',
            'main-functional-area-edit',
            'main-functional-area-delete',
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
            'job-post-list',
            'job-post-edit',
            'seeker-list',
            'seeker-edit',
            'seeker-delete',
            'employer-info-list',
            'employer-info-edit',
            'point-package-list',
            'point-package-create',
            'point-package-edit',
            'point-package-delete',
            'point-topup-list',
            'point-topup-edit'
        ];
      
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
