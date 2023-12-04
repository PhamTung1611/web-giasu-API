<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('education_level')->insert([
            [
                'name' => 'Đại học Bách Khoa'
            ],
            [
                'name' => 'Đại học FPT'
            ],
            [
                'name' => 'Đại học Thương Mại'
            ],
            [
                'name' => 'Đại học Quốc gia Hà Nội'
            ]

        ]);
    }
}
