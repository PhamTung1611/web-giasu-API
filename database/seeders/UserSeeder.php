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
            'role' => 'teacher',
            'name' => 'Phạm Huy Tùng',
            'email' => 'tung@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone' => '0342757442',
            'password' => '123',
            'address' => 'hanoi',
            'school_id' => '001',
            'Citizen_card' => '00012364',
            'education_level' => 'Đại học',
            'class' => '1',
            'subject' => '1',
            'salary' => '1',
            'description' => 'Yêu nghề',
            'time_tutor' => '1',
            'status' => '1',
            'DistrictID' => '1',
            'Certificate' => 'none'
        ]);
        DB::table('users')->insert([
            'role' => 'teacher',
            'name' => 'Nguyễn Thị Ngọc Ánh',
            'email' => 'anh@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone' => '0342757432',
            'password' => '123',
            'address' => 'hanoi',
            'school_id' => '001',
            'Citizen_card' => '00012914',
            'education_level' => 'Đại học',
            'class' => '3',
            'subject' => '2',
            'salary' => '1',
            'description' => 'Yêu nghề',
            'time_tutor' => '1',
            'status' => '1',
            'DistrictID' => '2',
            'Certificate' => 'none'
        ]);
        DB::table('users')->insert([
            'role' => 'teacher',
            'name' => 'Hiếu',
            'email' => 'hieu@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone' => '0342757422',
            'password' => '123',
            'address' => 'hanoi',
            'school_id' => '001',
            'Citizen_card' => '00012314',
            'education_level' => 'Đại học',
            'class' => '2',
            'subject' => '4',
            'salary' => '1',
            'description' => 'Yêu nghề',
            'time_tutor' => '1',
            'status' => '1',
            'DistrictID' => '3',
            'Certificate' => 'none'
        ]);
        DB::table('users')->insert([
            'role' => 'teacher',
            'name' => 'Bắp Tiến Nghĩa',
            'email' => 'nghia@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone' => '0342757412',
            'password' => '123',
            'address' => 'hanoi',
            'school_id' => '001',
            'Citizen_card' => '00012314',
            'education_level' => 'Đại học',
            'class' => '6',
            'subject' => '2',
            'salary' => '1',
            'description' => 'Yêu nghề',
            'time_tutor' => '1',
            'status' => '1',
            'DistrictID' => '4',
            'Certificate' => 'none'
        ]);
        DB::table('users')->insert([
            [
                'role' => 'user',
                'name' => 'Ngô tiến nghĩa',
                'email' => 'nghiangu@gmail.com',
                'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
                'phone' => '0342757453',
                'password' => '123',
                'address' => 'hanoi',
                'DistrictID' => '5',
            ],
            [
                'role' => 'user',
                'name' => 'Vũ lê tiến',
                'email' => 'tien@gmail.com',
                'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
                'phone' => '0342757454',
                'password' => '123',
                'address' => 'hanoi',
                'DistrictID' => '5',
            ],
            [
                'role' => 'user',
                'name' => 'nguyễn văn a',
                'email' => 'nguyenvana@gmail.com',
                'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
                'phone' => '0342757455',
                'password' => '123',
                'address' => 'hanoi',
                'DistrictID' => '5',
            ]
        ]);
    }
}
