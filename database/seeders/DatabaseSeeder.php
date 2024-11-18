<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            EmpresaSeeder::class,
            LocalSeeder::class,
            DepartamentoSeeder::class,
            SubdepartamentoSeeder::class,
            EquipoSeeder::class,
            ComponenteSeeder::class,
            SubcomponenteSeeder::class,
        ]);
    }
}
