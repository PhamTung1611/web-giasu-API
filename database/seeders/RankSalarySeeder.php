<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RankSalarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rank_salaries')->insert([
            [
                'name' => 'Dưới 100k',
            ],
            [
                'name' => 'Từ 100k - 300k',
            ],
            [
                'name' => 'Từ 300k - 500k',
            ],
            [
                'name' => 'Trên 500k',
            ]
        ]);
    }
}
