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
                'value' => '6h - 10h'
            ],
            [
                'value' => '10h - 14h'
            ],
            [
                'value' => '14h - 18h'
            ],
            [
                'value' => '18h - 22h'
            ]
        ]);
    }
}
