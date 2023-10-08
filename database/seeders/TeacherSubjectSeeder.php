<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('teacher_subject')->insert([
            'TeacherID' => '001',
            'SubjectID' => '001',
        ]);
        DB::table('teacher_subject')->insert([ 
            'TeacherID' => '002',
            'SubjectID' => '002',
        ]);
    }
}
