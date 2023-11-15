<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Tax;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tax::create([
            'tax' => 1,
            'created_by' => 1
        ]);
    }
}
