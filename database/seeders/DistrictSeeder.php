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
                'name' => 'Đống Đa'
            ]
        );
        DB::table('district')->insert(
            [
                'name' => 'Nam Từ Liêm'
            ]
        );
        DB::table('district')->insert(
            [
                'name' => 'Hoàn Kiếm'
            ]
        );
    }
}
