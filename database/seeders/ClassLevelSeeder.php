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
                'class' => 'Lop 1',
            ],
            [
                'class' => 'Lop 2',
            ],
            [
                'class' => 'Lop 3',
            ],
            [
                'class' => 'Lop 4',
            ],
            [
                'class' => 'Lop 5',
            ],
            [
                'class' => 'Lop 6',
            ],
            [
                'class' => 'Lop 7',
            ],
        ]);
    }
}
