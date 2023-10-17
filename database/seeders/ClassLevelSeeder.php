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
                'subject' => 1
            ],
            [
                'class' => 'Lop 2',
                'subject' => 1
            ],
            [
                'class' => 'Lop 3',
                'subject' => 1
            ],
            [
                'class' => 'Lop 4',
                'subject' => 1
            ],

            [
                'class' => 'Lop 5',
                'subject' => 1
            ],
            [
                'class' => 'Lop 6',
                'subject' => 1
            ],
            [
                'class' => 'Lop 7',
                'subject' => 1
            ],

            
        ]);
    }
}
