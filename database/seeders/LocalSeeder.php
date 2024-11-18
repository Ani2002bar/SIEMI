<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Local;

class LocalSeeder extends Seeder
{
    public function run()
    {
        Local::factory()->count(5)->create();
    }
}
