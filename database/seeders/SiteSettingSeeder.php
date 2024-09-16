<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteSetting::create([
            'site_title' => 'Infinity Careers',
            'created_by' => 1
        ]);
    }
}
