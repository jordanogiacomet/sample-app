<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Support\Facades\DB; // Adicione esta linha para importar a classe DB

class UserSeeder extends Seeder
{

    use TruncateTable;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $this->truncate('users'); 
        User::factory(10)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

       
    }
}