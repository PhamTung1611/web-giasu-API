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
            'idSender'=>'5',
            'idTeacher'=>'1',
            'point'=>'5',
            'description'=>'Dạy tốt'
        ],
        [
            'idSender'=>'6',
            'idTeacher'=>'2',
            'point'=>'4',
            'description'=>'Dạy tốt'
        ],
        [
            'idSender'=>'5',
            'idTeacher'=>'1',
            'point'=>'5',
            'description'=>'Dạy hay'
        ],
    ]);
    }
}
