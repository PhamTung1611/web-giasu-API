<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('users')->insert([
            'role'=>'admin',
            'name' => 'Phạm Huy Tùng',
            'email'=>'tung@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone'=>'0342757452',
            'password'=>Hash::make('123'),
            'address'=>'hanoi',
            'school_id'=>'001',
            'Citizen_card'=>'00012364',
            'education_level'=>'Đại học',
            'class'=>'1',
            'subject'=>'1',
            'salary'=>'1',
            'description'=>'Yêu nghề',
            'time_tutor'=>'1',
            'status'=>'1',
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
            'subject'=>'2',
            'salary'=>'1',
            'description'=>'Yêu nghề',
            'time_tutor'=>'1',
            'status'=>'1',
            'DistrictID'=>'2',
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
            'subject'=>'4',
            'salary'=>'1',
            'description'=>'Yêu nghề',
            'time_tutor'=>'1',
            'status'=>'1',
            'DistrictID'=>'3',
            'Certificate'=>'none'
        ]);
        DB::table('users')->insert([
            'role'=>'teacher',
            'name' => 'nghia',
            'email'=>'nghia@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone'=>'0342757452',
            'password'=>Hash::make('123'),
            'address'=>'hanoi',
            'school_id'=>'001',
            'Citizen_card'=>'00012314',
            'education_level'=>'Đại học',
            'class'=>'6',
            'subject'=>'2',
            'salary'=>'1',
            'description'=>'Yêu nghề',
            'time_tutor'=>'1',
            'status'=>'1',
            'DistrictID'=>'4',
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
            'DistrictID'=>'5',
        ]);
    }
}
