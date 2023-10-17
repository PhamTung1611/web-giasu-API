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
                [
                    'name' => 'Đống Đa'
                ],
                [
                    'name' => 'Nam Từ Liêm'
                ],
                [
                    'name' => 'Hoàn Kiếm'
                ],
                [
                    'name' => 'Long Biên'
                ],
                [
                    'name' => 'Thanh Xuân'
                ],
                [
                    'name' => 'Ba Đình'
                ],
                [
                    'name'=>'Hà Đông'
                ]
            ]
        );
    }
}
