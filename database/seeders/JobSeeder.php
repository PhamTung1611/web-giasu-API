<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('jobs')->insert([
            [
                'id_user' => '11',
                'id_teacher'=>'4',
                'subject'=>'1,2,3',
                'class'=>'2,3'
            ],
            [
                'id_user' => '10',
                'id_teacher'=>'3',
                'subject'=>'1,2,3',
                'class'=>'2,3'
            ],
            [
                'id_user' => '10',
                'id_teacher'=>'4',
                'subject'=>'2,3',
                'class'=>'4,5'
            ],
        ]);
    }
}
