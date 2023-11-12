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
            'email'=>'admin@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone'=>'0342757454',
            'password'=>Hash::make('123'),
            'address'=>'Đống Đa',
            'school_id'=>'001',
            'Citizen_card'=>'00012364',
            'education_level'=>'Đại học',
            'class_id'=>'1',
            'subject'=>'1',
            'salary_id'=>'1',
            'description'=>'5 năm',
            'time_tutor_id'=>'1',
            'status'=>'1',
            'DistrictID'=>'1',
            'Certificate'=>'none',
            'date_of_birth'=>'2003-09-30',
            'gender'=>'Nam'

        ]);
        DB::table('users')->insert([
            'role'=>'teacher',
            'name' => 'Ngọc Ánh',
            'email'=>'anh@gmail.com',
            'avatar' => 'hinh/default.jpg',
            'phone'=>'0832455611',
            'password'=>Hash::make('123'),
            'address'=>'Hà Đông',
            'school_id'=>'001',
            'Citizen_card'=>'00012914',
            'education_level'=>'Đại học',
            'class_id'=>'3',
            'subject'=>'2',
            'salary_id'=>'1',
            'exp'=>'2',
            'current_role'=>'Sinh viên',
            'description'=>'1 năm',
            'time_tutor_id'=>'1',
            'status'=>'1',
            'DistrictID'=>'2',
            'Certificate'=>null,
            'date_of_birth'=>'2003-02-23',
            'gender'=>'Nữ'
        ]);
        DB::table('users')->insert([
            'role'=>'teacher',
            'name' => 'Quang Hiếu',
            'email'=>'hieu@gmail.com',
            'avatar' => 'hinh/default.jpg',
            'phone'=>'0342667452',
            'password'=>Hash::make('123'),
            'address'=>'Bắc Từ Liêm',
            'school_id'=>'001',
            'Citizen_card'=>'00012314',
            'education_level'=>'Đại học',
            'class_id'=>'2',
            'subject'=>'4',
            'salary_id'=>'1',
            'exp'=>'1',
            'current_role'=>'Sinh viên',
            'description'=>'6 tháng',
            'time_tutor_id'=>'1',
            'status'=>'1',
            'DistrictID'=>'3',
            'Certificate'=>null,
            'date_of_birth'=>'2003-09-30',
            'gender'=>'Nam'
        ]);
        DB::table('users')->insert([
            'role'=>'teacher',
            'name' => 'Ngô Tiến Nghĩa',
            'email'=>'nghia@gmail.com',
            'avatar' => 'hinh/default.jpg',
            'phone'=>'0342757452',
            'password'=>Hash::make('123'),
            'address'=>'Hoàn Kiếm',
            'school_id'=>'001',
            'Citizen_card'=>'00012314',
            'education_level'=>'Đại học',
            'class_id'=>'6,2',
            'subject'=>'2',
            'salary_id'=>'1',
            'exp'=>'3',
            'current_role'=>'Sinh viên',
            'description'=>'2 năm',
            'time_tutor_id'=>'1',
            'status'=>'1',
            'DistrictID'=>'4',
            'Certificate'=>null,
            'date_of_birth'=>'2003-09-30',
            'gender'=>'Nam'
        ]);
        DB::table('users')->insert([
            'role'=>'teacher',
            'name' => 'Nguyễn Đức Trường',
            'email'=>'truongnguyen@gmail.com',
            'avatar' => 'hinh/default.jpg',
            'phone'=>'0766275745',
            'password'=>Hash::make('123'),
            'address'=>'Nam Từ Liêm',
            'school_id'=>'001',
            'Citizen_card'=>'00012314',
            'education_level'=>'Đại học',
            'class_id'=>'6,2',
            'subject'=>'2',
            'salary_id'=>'1',
            'exp'=>'7',
            'current_role'=>'Giáo viên',
            'description'=>'6 năm',
            'time_tutor_id'=>'1',
            'status'=>'1',
            'DistrictID'=>'4',
            'Certificate'=>null,
            'date_of_birth'=>'2002-09-03',
            'gender'=>'Nam'
        ]);
        DB::table('users')->insert([
            'role'=>'teacher',
            'name' => 'Phạm Huy Tùng',
            'email'=>'tungpham@gmail.com',
            'avatar' => 'hinh/default.jpg',
            'phone'=>'0766275225',
            'password'=>'123',
            'address'=>'Đống Đa',
            'school_id'=>'001',
            'Citizen_card'=>'00044314',
            'education_level'=>'Đại học',
            'class_id'=>'1,5',
            'subject'=>'6',
            'salary_id'=>'1',
            'exp'=>'4',
            'current_role'=>'Giáo viên',
            'description'=>'3 năm',
            'time_tutor_id'=>'3',
            'status'=>'2',
            'DistrictID'=>'4',
            'Certificate'=>null,
            'date_of_birth'=>'2000-09-03',
            'gender'=>'Nam'
        ]);
        DB::table('users')->insert([
            'role'=>'teacher',
            'name' => 'Sơn Phạm',
            'email'=>'sonpi@gmail.com',
            'avatar' => 'hinh/default.jpg',
            'phone'=>'0906275225',
            'password'=>'123',
            'address'=>'Nguyễn Trãi',
            'school_id'=>'001',
            'Citizen_card'=>'00044314',
            'education_level'=>'Đại học',
            'class_id'=>'2,5',
            'subject'=>'3',
            'salary_id'=>'1',
            'exp'=>'2',
            'current_role'=>'Sinh viên',
            'description'=>'1 năm',
            'time_tutor_id'=>'4',
            'status'=>'2',
            'DistrictID'=>'4',
            'Certificate'=>null,
            'date_of_birth'=>'1992-11-22',
            'gender'=>'Nam'
        ]);
        DB::table('users')->insert([
            'role'=>'teacher',
            'name' => 'Ánh Nguyễn',
            'email'=>'anhnguyen@gmail.com',
            'avatar' => 'hinh/default.jpg',
            'phone'=>'0906225225',
            'password'=>'123',
            'address'=>'Nguyễn Tuân',
            'school_id'=>'001',
            'Citizen_card'=>'00044314',
            'education_level'=>'Đại học',
            'class_id'=>'3,4',
            'subject'=>'2',
            'salary_id'=>'1',
            'exp'=>'2',
            'current_role'=>'Sinh viên',
            'description'=>'1 năm',
            'time_tutor_id'=>'2',
            'status'=>'2',
            'DistrictID'=>'4',
            'Certificate'=>null,
            'date_of_birth'=>'2001-11-22',
            'gender'=>'Nữ'
        ]);
        DB::table('users')->insert([
            'role'=>'teacher',
            'name' => 'Tạ Huy',
            'email'=>'huytq@gmail.com',
            'avatar' => 'hinh/default.jpg',
            'phone'=>'0806225225',
            'password'=>'123',
            'address'=>'Bắc Từ Liêm',
            'school_id'=>'001',
            'Citizen_card'=>'00044314',
            'education_level'=>'Đại học',
            'class_id'=>'2,4',
            'subject'=>'5',
            'salary_id'=>'1',
            'exp'=>'7',
            'current_role'=>'Giảng viên',
            'description'=>'6 năm',
            'time_tutor_id'=>'2',
            'status'=>'2',
            'DistrictID'=>'4',
            'Certificate'=>null,
            'date_of_birth'=>'2001-11-22',
            'gender'=>'Nam'
        ]);
        DB::table('users')->insert([
            'role'=>'user',
            'name' => 'Nghĩa Ngô',
            'email'=>'nghiangu@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone'=>'0377757452',
            'password'=>Hash::make('123'),
            'address'=>'Ba Đình',
            'DistrictID'=>'5',
            'date_of_birth'=>'2003-09-30',
            'gender'=>'Nam'
        ]);
        DB::table('users')->insert([
            'role'=>'user',
            'name' => 'Quang Huy',
            'email'=>'quanghuy@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone'=>'0942757452',
            'password'=>Hash::make('123'),
            'address'=>'Thanh Xuân Trung',
            'DistrictID'=>'2',
            'date_of_birth'=>'2003-05-26',
            'gender'=>'Nam'
        ]);
        DB::table('users')->insert([
            'role'=>'user',
            'name' => 'Lê Tiến',
            'email'=>'letien@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone'=>'0842757452',
            'password'=>Hash::make('123'),
            'address'=>'Thanh Xuân',
            'DistrictID'=>'6',
            'date_of_birth'=>'2003-04-27',
            'gender'=>'Nam'
        ]);
        DB::table('users')->insert([
            'role'=>'user',
            'name' => 'Phạm Văn Sơn',
            'email'=>'sonpham@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone'=>'0342757411',
            'password'=>Hash::make('123'),
            'address'=>'Triều Khúc',
            'DistrictID'=>'3',
            'date_of_birth'=>'1992-02-02',
            'gender'=>'Nam'
        ]);
    }
}
