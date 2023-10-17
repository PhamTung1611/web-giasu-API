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
            'role'=>'teacher',
            'name' => 'tung',
            'email'=>'tung@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone'=>'0342757452',
            'password'=>'123',
            'address'=>'hanoi',
            'school_id'=>'001',
            'Citizen_card'=>'00012364',
            'education_level'=>'Đại học',
            'class'=>'1',
            'subject'=>'1',
            'salary'=>'1',
            'description'=>'Yêu nghề',
            'time_tutor'=>'1',
            'status'=>'active',
            'DistrictID'=>'1',
            'Certificate'=>'none'
        ]);
        DB::table('users')->insert([
            'role'=>'teacher',
            'name' => 'anh',
            'email'=>'anh@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone'=>'0342757452',
            'password'=>'123',
            'address'=>'hanoi',
            'school_id'=>'001',
            'Citizen_card'=>'00012914',
            'education_level'=>'Đại học',
            'class'=>'3',
            'subject'=>'1',
            'salary'=>'1',
            'description'=>'Yêu nghề',
            'time_tutor'=>'1',
            'status'=>'active',
            'DistrictID'=>'1',
            'Certificate'=>'none'
        ]);
        DB::table('users')->insert([
            'role'=>'teacher',
            'name' => 'hieu',
            'email'=>'hieu@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone'=>'0342757452',
            'password'=>'123',
            'address'=>'hanoi',
            'school_id'=>'001',
            'Citizen_card'=>'00012314',
            'education_level'=>'Đại học',
            'class'=>'2',
            'subject'=>'1',
            'salary'=>'1',
            'description'=>'Yêu nghề',
            'time_tutor'=>'1',
            'status'=>'active',
            'DistrictID'=>'1',
            'Certificate'=>'none'
        ]);
        DB::table('users')->insert([
            'role'=>'teacher',
            'name' => 'nghia',
            'email'=>'nghia@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone'=>'0342757452',
            'password'=>'123',
            'address'=>'hanoi',
            'school_id'=>'001',
            'Citizen_card'=>'00012314',
            'education_level'=>'Đại học',
            'class'=>'6',
            'subject'=>'1',
            'salary'=>'1',
            'description'=>'Yêu nghề',
            'time_tutor'=>'1',
            'status'=>'active',
            'DistrictID'=>'001',
            'Certificate'=>'none'
        ]);
        DB::table('users')->insert([
            'role'=>'user',
            'name' => 'nghia',
            'email'=>'nghiangu@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone'=>'0342757452',
            'password'=>'123',
            'address'=>'hanoi',
        ]);
    }
}
