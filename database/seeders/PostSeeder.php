<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\TruncateTable;
use Database\Factories\Helpers\FactoryHelper;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{

    use TruncateTable, DisableForeignKeys;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();
        $this->truncate('posts');
        $posts = Post::factory(10)->create();
        $this->enableForeignKeys();

        $posts->each(function(Post $post){
            $post->users()->sync([FactoryHelper::getRandomModelId(User::class)]);
        });

    }
}
