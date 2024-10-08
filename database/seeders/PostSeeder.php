<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'user_id' => '1',
            'result_id' => '1',
            'content' => 'test',
            'image_url' => 'hello.world',
        ]);

    }
}
