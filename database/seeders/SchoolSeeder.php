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
                    'name' => 'Đại học Sư Phạm Hà Nội'

                ],
                [
                    'name' => 'Đại học Sư Phạm Hà Nội 2'

                ],
                [
                    'name' => 'Học Viện Bưu Chính Viễn Thông'

                ],
                [
                    'name' => 'Cao đẳng FPT Polytechnic Hà Nội'

                ],
                [
                    'name' => 'Cao đẳng nghề Bách Khoa Hà Nội'

                ],
                [
                    'name' => 'Đại học Hà Nội'

                ],
                [
                    'name' => 'Đại học Ngoại Thương'

                ],
                [
                    'name' => 'Đại học Thương Mại'

                ],
                [
                    'name' => 'Đại học Kiến Trúc'

                ],
                [
                    'name' => 'Cao đẳng Thương mại Du lịch Hà Nội'

                ],
            ]
        );
    }
}
