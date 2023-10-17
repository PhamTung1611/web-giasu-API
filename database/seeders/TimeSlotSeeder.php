<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('time_slots')->insert([
            [
                'name' => '6h - 10h'
            ],
            [
                'name' => '10h - 14h'
            ],
            [
                'name' => '14h - 18h'
            ],
            [
                'name' => '18h - 22h'
            ]
        ]);
    }
}
