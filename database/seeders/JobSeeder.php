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
        // DB::table('jobs')->insert([
        //     [
        //         'title' => 'Title 1',
        //         'name' => 'name1',
        //         'address' => 'ad1',
        //         'date_time' => 'date_time1',
        //         'phone' => '0862178842',
        //         'email' => 'huytqph27342@fpt.edu.vn',
        //         'subjects_need' => 'hihi',
        //         'education_level' => 'Đại học',
        //         'salary' => '5000',
        //         'requirements' => 'gjod'
        //     ],
        // ]);

        DB::table('jobs')->insert([
            [
                'id_user' => '4',
                'id_teacher'=>'2',
                'subject'=>'[1,2,3]',
                'class'=>'[2,3]'
            ],
            [
                'id_user' => '5',
                'id_teacher'=>'1',
                'subject'=>'[1,2,3]',
                'class'=>'[2,3]'
            ],
            [
                'id_user' => '5',
                'id_teacher'=>'2',
                'subject'=>'[2,3]',
                'class'=>'[4,5]'
            ],
        ]);
    }
}
