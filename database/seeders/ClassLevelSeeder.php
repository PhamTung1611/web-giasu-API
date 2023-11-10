<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('class_levels')->insert([
            [
                'class' => 'Lớp 1',
            ],
            [
                'class' => 'Lớp 2',
            ],
            [
                'class' => 'Lớp 3',
            ],
            [
                'class' => 'Lớp 4',
            ],

            [
                'class' => 'Lớp 5',
            ],
            [
                'class' => 'Lớp 6',
            ],
            [
                'class' => 'Lớp 7',
            ],
        ]);
    }
}
