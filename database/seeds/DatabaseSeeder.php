<?php

use Illuminate\Database\Seeder;
use App\clientes;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClientesSeeder::class);
        $this->call(MonitoresSeeder::class);
    }
}
