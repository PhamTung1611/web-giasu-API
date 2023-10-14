<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('users')->insert([
            'role_id'=>'admin',
            'name' => 'tung',
            'email'=>'tung@gmail.com',
            'avatar' => '',
            'phone'=>'0342757452',
            'password'=>'123',
            'address'=>'hanoi',
        ]);
    }
}
