<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert([
            [
                'name' => 'Môn Toán'
            ],
            [
                'name' => 'Môn Văn'
            ],
            [
                'name' => 'Môn Hóa'
            ],
            [
                'name' => 'Môn Vật Lý'
            ],
            [
                'name' => 'Môn Sinh'
            ],
            [
                'name' => 'Môn Địa'
            ],

        ]);
    }
}
