<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\TruncateTable;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Support\Facades\DB; // Adicione esta linha para importar a classe DB

class UserSeeder extends Seeder
{

    use TruncateTable, DisableForeignKeys;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();
        $this->truncate('users'); 
        User::factory(10)->create();
        $this->enableForeignKeys();
       

       
    }
}