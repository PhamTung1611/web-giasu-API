<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('district')->insert(
            [
                'user_id'=>'1',
                'name' => 'Đống Đa'
            ]
        );
        DB::table('district')->insert(
            [
                'user_id'=>'2',
                'name' => 'Nam Từ Liêm'
            ]
        );
        DB::table('district')->insert(
            [
                'user_id'=>'3',
                'name' => 'Hoàn Kiếm'
            ]
        );
    }
}
