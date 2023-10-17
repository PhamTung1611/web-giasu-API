<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('schools')->insert(
            [
                [
                    'name' => 'Đại học FPT'

                ],
                [
                    'name' => 'Đại học Luật'

                ],
                [
                    'name' => 'Đại học Bách Khoa'

                ],
                [
                    'name' => 'Đại học Ngoại Thương'

                ],
            ]
        );
    }
}
