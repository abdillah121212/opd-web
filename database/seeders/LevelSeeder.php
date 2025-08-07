<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\Level::create(['name' => 'admin']);
    \App\Models\Level::create(['name' => 'user']);
}
}
