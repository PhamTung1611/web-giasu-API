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
            'role'=>1,
            'name' => 'Phạm Huy Tùng',
            'email'=>'admin@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'password'=>Hash::make('123'),
            'address'=>'Đống Đa',
            'status'=>'1',
            'date_of_birth'=>'2003-09-30',
            'gender'=>1, 'coin'=>1

        ]);
        DB::table('users')->insert([
            'role'=>4,
            'name' => 'Ngọc Ánh',
            'email'=>'ctv@gmail.com',
            'avatar' => 'hinh/default.jpg',
            'phone'=>'0832455611',
            'password'=>Hash::make('123'),
            'address'=>'Hà Đông',
            'school_id'=>'001',
            'education_level'=>'1,3',
            'class_id'=>'3',
            'subject'=>'2',
            'salary_id'=>'1',
            'exp'=>'2',
            'current_role'=>'Sinh viên',
            'description'=>'1 năm',
            'time_tutor_id'=>'1',
            'status'=>'1',
            'District_ID'=>'Quận Hai Bà Trưng, Hà Nội',
            'longitude'=>"105.84972309300008",
            'latitude'=>"21.010176768000065",
            'Certificate'=>null,
            'date_of_birth'=>'2003-02-23',
            'gender'=>'Nữ',
            'coin'=>1000000
        ]);
        DB::table('users')->insert([
            'role'=>3,
            'name' => 'Quang Hiếu',
            'email'=>'hieu@gmail.com',
            'avatar' => 'hinh/default.jpg',
            'phone'=>'0342667452',
            'password'=>Hash::make('123'),
            'address'=>'Bắc Từ Liêm',
            'school_id'=>'001',
            'education_level'=>'1',
            'class_id'=>'2',
            'subject'=>'4',
            'salary_id'=>'1',
            'exp'=>'1',
            'current_role'=>'Sinh viên',
            'description'=>'6 tháng',
            'time_tutor_id'=>'1',
            'status'=>'1',
            'District_ID'=>'Quận Đống Đa, Hà Nội',
            'longitude'=>"105.83091482900005",
            'latitude'=>"21.019302192000055",
            'Certificate'=>null,
            'date_of_birth'=>'2003-09-30',
            'gender'=>'Nam', 'coin'=>1000000
        ]);
        DB::table('users')->insert([
            'role'=>3,
            'name' => 'Ngô Tiến Nghĩa',
            'email'=>'nghia@gmail.com',
            'avatar' => 'hinh/default.jpg',
            'phone'=>'0342757452',
            'password'=>Hash::make('123'),
            'address'=>'Hoàn Kiếm',
            'school_id'=>'001',
            'education_level'=>'2',
            'class_id'=>'6,2',
            'subject'=>'2',
            'salary_id'=>'1',
            'exp'=>'3',
            'current_role'=>'Sinh viên',
            'description'=>'2 năm',
            'time_tutor_id'=>'1',
            'status'=>'1',
            'District_ID'=>'Quận Hà Đông, Hà Nội',
            'longitude'=>"105.77875462800006",
            'latitude'=>"20.971334803000047",
            'Certificate'=>null,
            'date_of_birth'=>'2003-09-30',
            'gender'=>'Nam', 'coin'=>1000000
        ]);
        DB::table('users')->insert([
            'role'=>3,
            'name' => 'Nguyễn Đức Trường',
            'email'=>'truongnguyen@gmail.com',
            'avatar' => 'hinh/default.jpg',
            'phone'=>'0766275745',
            'password'=>Hash::make('123'),
            'address'=>'Nam Từ Liêm',
            'school_id'=>'001',
            'education_level'=>'2',
            'class_id'=>'6,2',
            'subject'=>'2',
            'salary_id'=>'1',
            'exp'=>'7',
            'current_role'=>'Giáo viên',
            'description'=>'6 năm',
            'time_tutor_id'=>'1',
            'status'=>'1',
            'District_ID'=>'Quận Thanh Xuân, Hà Nội',
            'longitude'=>"105.79978623600005",
            'latitude'=>"20.99477765200004",
            'Certificate'=>null,
            'date_of_birth'=>'2002-09-03',
            'gender'=>1, 'coin'=>1
        ]);
        DB::table('users')->insert([
            'role'=>3,
            'name' => 'Phạm Huy Tùng',
            'email'=>'tungpham@gmail.com',
            'avatar' => 'hinh/default.jpg',
            'phone'=>'0766275225',
            'password'=>Hash::make('123'),
            'address'=>'Đống Đa',
            'school_id'=>'001',
            'education_level'=>'4',
            'class_id'=>'1,5',
            'subject'=>'6',
            'salary_id'=>'1',
            'exp'=>'4',
            'current_role'=>'Giáo viên',
            'description'=>'3 năm',
            'time_tutor_id'=>'3',
            'status'=>'2',
            'District_ID'=>'Quận Hoàng Mai, Hà Nội',
            'longitude'=>"105.84435436900009",
            'latitude'=>"20.97535979500003",
            'Certificate'=>null,
            'date_of_birth'=>'2000-09-03',
            'gender'=>1, 'coin'=>1
        ]);
        DB::table('users')->insert([
            'role'=>3,
            'name' => 'Sơn Phạm',
            'email'=>'sonpi@gmail.com',
            'avatar' => 'hinh/default.jpg',
            'phone'=>'0906275225',
            'password'=>Hash::make('123'),
            'address'=>'Nguyễn Trãi',
            'school_id'=>'001',
            'education_level'=>'1',
            'class_id'=>'2,5',
            'subject'=>'3',
            'salary_id'=>'1',
            'exp'=>'2',
            'current_role'=>'Sinh viên',
            'description'=>'1 năm',
            'time_tutor_id'=>'4',
            'status'=>'2',
            'District_ID'=>'Quận Hoàng Mai, Hà Nội',
            'longitude'=>"105.84435436900009",
            'latitude'=>"20.97535979500003",
            'Certificate'=>null,
            'date_of_birth'=>'1992-11-22',
            'gender'=>1, 'coin'=>1
        ]);
        DB::table('users')->insert([
            'role'=>3,
            'name' => 'Ánh Nguyễn',
            'email'=>'anhnguyen@gmail.com',
            'avatar' => 'hinh/default.jpg',
            'phone'=>'0906225225',
            'password'=>Hash::make('123'),
            'address'=>'Nguyễn Tuân',
            'school_id'=>'001',
            'education_level'=>'3',
            'class_id'=>'3,4',
            'subject'=>'2',
            'salary_id'=>'1',
            'exp'=>'2',
            'current_role'=>'Sinh viên',
            'description'=>'1 năm',
            'time_tutor_id'=>'2',
            'status'=>'2',
            'District_ID'=>'Quận Hoàng Mai, Hà Nội',
            'longitude'=>"105.84435436900009",
            'latitude'=>"20.97535979500003",
            'Certificate'=>null,
            'date_of_birth'=>'2001-11-22',
            'gender'=>0, 'coin'=>1
        ]);
        DB::table('users')->insert([
            'role'=>3,
            'name' => 'Tạ Huy',
            'email'=>'huytq@gmail.com',
            'avatar' => 'hinh/default.jpg',
            'phone'=>'0806225225',
            'password'=>Hash::make('123'),
            'address'=>'Bắc Từ Liêm',
            'school_id'=>'001',
            'education_level'=>'2',
            'class_id'=>'2,4',
            'subject'=>'5',
            'salary_id'=>'1',
            'exp'=>'7',
            'current_role'=>'Giảng viên',
            'description'=>'6 năm',
            'time_tutor_id'=>'2',
            'status'=>'2',
            'District_ID'=>'Quận Hoàng Mai, Hà Nội',
            'longitude'=>"105.84435436900009",
            'latitude'=>"20.97535979500003",
            'Certificate'=>null,
            'date_of_birth'=>'2001-11-22',
            'gender'=>0,
            'coin'=>1
        ]);
        DB::table('users')->insert([
            'role'=>2,
            'name' => 'Nghĩa Ngô',
            'email'=>'nghiangu@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone'=>'0377757452',
            'password'=>Hash::make('123'),
            'address'=>'Ba Đình',
            'District_ID'=>'Quận Hoàng Mai, Hà Nội',
            'longitude'=>"105.84435436900009",
            'latitude'=>"20.97535979500003",
            'date_of_birth'=>'2003-09-30',
            'gender'=>1,
            'status'=>"1",
            'coin'=>1000000
        ]);
        DB::table('users')->insert([
            'role'=>2,
            'name' => 'Quang Huy',
            'email'=>'quanghuy@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone'=>'0942757452',
            'password'=>Hash::make('123'),
            'address'=>'Thanh Xuân Trung',
            'District_ID'=>'Quận Hoàng Mai, Hà Nội',
            'longitude'=>"105.84435436900009",
            'latitude'=>"20.97535979500003",
            'date_of_birth'=>'2003-05-26',
            'gender'=>1,
            'status'=>"1",
            'coin'=>1
        ]);
        DB::table('users')->insert([
            'role'=>2,
            'name' => 'Lê Tiến',
            'email'=>'letien@gmail.com',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone'=>'0842757452',
            'password'=>Hash::make('123'),
            'address'=>'Thanh Xuân',
            'District_ID'=>'Quận Hoàng Mai, Hà Nội',
            'longitude'=>"105.84435436900009",
            'latitude'=>"20.97535979500003",
            'date_of_birth'=>'2003-04-27',
            'gender'=>1,
            'status'=>"1",
            'coin'=>1

        ]);
        DB::table('users')->insert([
            'role'=>2,
            'name' => 'Phạm Văn Sơn',
            'email'=>'sonpvph27505@fpt.edu.vn',
            'avatar' => 'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
            'phone'=>'0342757411',
            'password'=>Hash::make('123'),
            'address'=>'Triều Khúc',
            'District_ID'=>'Quận Hoàn Kiếm, Hà Nội',
            'longitude'=>"105.85077074900005",
            'latitude'=>"21.028530775000036",
            'date_of_birth'=>'1992-02-02',
            'gender'=>1,
            'status'=>"1",
            'coin'=>1
        ]);
    }
}
