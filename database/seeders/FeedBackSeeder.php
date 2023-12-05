<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class FeedBackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('feedback')->insert([[
            'id_sender'=>'5',
            'id_teacher'=>'2',
            'point'=>'5',
            'description'=>'Dạy tốt'
        ],
        [
            'id_sender'=>'6',
            'id_teacher'=>'2',
            'point'=>'4',
            'description'=>'Dạy tốt'
        ],
        [
            'id_sender'=>'5',
            'id_teacher'=>'3',
            'point'=>'5',
            'description'=>'Dạy hay'
        ],
    ]);
    }
}
