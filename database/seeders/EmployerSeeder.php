<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Employer;
use Hash;

class EmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employer::create([
            'name' => "Infinity Career",
            'email' => "infinitycareer@gmail.com",
            'password' => Hash::make('password')
        ]);
    }
}
