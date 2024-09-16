<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EmployerSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(TaxSeeder::class);
        $this->call(SiteSettingSeeder::class);
        $this->call(InPersonBookingTimeSeeder::class);
        $this->call(OnlineBookingTimeSeeder::class);

        // \App\Models\User::factory(10)->create();
    }
}
