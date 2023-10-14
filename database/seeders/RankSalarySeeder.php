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
                'value' => 'Dưới 100k',
            ],
            [
                'value' => 'Từ 100k - 300k',
            ],
            [
                'value' => 'Từ 300k - 500k',
            ],
            [
                'value' => 'Trên 500k',
            ]
        ]);
    }
}
