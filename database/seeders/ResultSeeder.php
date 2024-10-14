<?php

namespace Database\Seeders;

use App\Models\Result;
use Illuminate\Database\Seeder;

class ResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = ['apple' => 'ringo',
            'orange' => 'midori'];

        Result::create([
            'user_id' => 1,
            'data_json' => json_encode($arr),
            'date' => 1,
        ]);
    }
}
