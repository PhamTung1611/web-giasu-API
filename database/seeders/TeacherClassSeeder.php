<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('teacher_class')->insert([
            'TeacherID' => '001',
            'ClassID' => '001',
        ]);
        DB::table('teacher_class')->insert([
            'TeacherID' => '002',
            'ClassID' => '002',
        ]);
    }
}
