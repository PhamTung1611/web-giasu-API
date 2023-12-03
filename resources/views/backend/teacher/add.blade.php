@extends('template.layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
  <div class="d-block mb-4 mb-md-0">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
      <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
        <li class="breadcrumb-item">
          <a href="#">
            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
              </path>
            </svg>
          </a>
        </li>
        {{-- <li class="breadcrumb-item"><a href="#">Tables</a></li> --}}
      </ol>
    </nav>
    <h2 class="h4">{{$title}}</h2>
  </div>
</div>
<div class="table-settings mb-4">
  <div class="row align-items-center justify-content-between">
    <div class="col col-md-6 col-lg-3 col-xl-4">
      <form class="input-group me-2 me-lg-3 fmxw-400">
        <span class="input-group-text">
          <svg class="icon icon-xs" x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
          </svg>
        </span>
        <input type="text" class="form-control" placeholder="Search job">
      </form>
    </div>
    <div class="col-4 col-md-2 col-xl-1 ps-md-0 text-end">
      <div class="dropdown">
        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
          </svg>
          <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end pb-0">
          <span class="small ps-3 fw-bold text-dark">Show</span>
          <a class="dropdown-item d-flex align-items-center fw-bold" href="#">10 <svg class="icon icon-xxs ms-auto" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg></a>
          <a class="dropdown-item fw-bold" href="#">20</a>
          <a class="dropdown-item fw-bold rounded-bottom" href="#">30</a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="card card-body border-0 shadow mb-4">
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <p style="color: red;">{{ $error }}</p>
    @endforeach
    @endif
    <form action="{{ route('add_teacher') }}" method="POST" enctype="multipart/form-data" style="width: 1200px" class="mx-auto mb-4">
      @csrf
      <div class="row">
        <div class="col-md-12 mb-3">
          <div>
            <input type="text" name="role" value="teacher" hidden>
            <label>Họ và Tên</label><br>
            <input type="text" class="form-control" placeholder="Nhập tên user" name="name">
            <label>Email</label><br>
            <input type="email" class="form-control" placeholder="Nhập email" name="email">
            <label>Mật khẩu</label><br>
            <input type="password" class="form-control" placeholder="Nhập password" name="password">
            <label>Avatar</label><br>
            {{-- <input type="text" class="form-control" placeholder="Nhập link Avatar" name="avatar"> --}}
            <input type="file" placeholder="" name="avatar" accept="hinh/*" class="mb-3 form-control @error('avatar') is-invalid @enderror" id="avatar">
            <label>Số điện thoại</label><br>
            <input type="text" class="form-control" placeholder="Nhập Số điện thoại" name="phone">
            <label>Địa chỉ</label><br>
            <input type="text" class="form-control" placeholder="Nhập Địa chỉ" name="address">
            <label>Trường học</label><br>
            <select name="school_id" id="" class="form-control">
              @foreach($school as $s)
              <option class="form-control" name="school_id" value="{{$s->id}}">{{$s->name}}</option>
              @endforeach
            </select>
            {{-- <label>Số căn cước hoặc chứng minh thư</label><br>
            <input type="text" class="form-control" placeholder="Nhập Số căn cước hoặc chứng minh thư" name="Citizen_card"> --}}
            <label>Trình độ học vấn</label><br>
            <input type="text" class="form-control" placeholder="Nhập trình độ học vấn" name="education_level">
            <label>Lớp muốn dạy</label><br>
            <select name="class" id="" class="form-control">
              @foreach($class as $s)
              <option class="form-control" name="class" value="{{$s->id}}">{{$s->class}}</option>
              @endforeach
            </select>
              <label>Kinh nghiệm</label><br>
              <select name="exp" id="" class="form-control">
                  <option class="form-control" name="class" value="0">0 Năm</option>
                  <option class="form-control" name="class" value="1">1 Năm</option>
                  <option class="form-control" name="class" value="2">2 Năm</option>
                  <option class="form-control" name="class" value="3">3 Năm</option>
                  <option class="form-control" name="class" value="4">4 Năm</option>
                  <option class="form-control" name="class" value="5">5 Năm</option>
                  <option class="form-control" name="class" value="6"> >5 Năm</option>
              </select>
              <label>Vai trò hiện tại</label><br>
              <input type="text" class="form-control" placeholder="Nhập vai trò hiện tại" name="current_role">
            <label>Môn học muốn dạy</label><br>
            <select name="subject" id="" class="form-control">
              @foreach($subject as $s)
              <option class="form-control" name="subject" value="{{$s->id}}">{{$s->name}}</option>
              @endforeach
            </select>
            <label>Mức lương</label><br>
            <select name="salary" id="" class="form-control">
              @foreach($salary as $s)
              <option class="form-control" name="salary" value="{{$s->id}}">{{$s->name}}</option>
              @endforeach
            </select>
            <label>Quận/Huyện muốn dạy</label><br>
            <input type="text" class="form-control" placeholder="Nhập quận huyện muốn dạy" name="DistrictID">
            <label>Chọn thời gian dạy</label><br>
            <select name="time_tutor" id="" class="form-control">
              @foreach($timeTutor as $s)
              <option class="form-control" name="time_tutor" value="{{$s->id}}">{{$s->name}}</option>
              @endforeach
            </select>
              <label>Ảnh bằng cấp</label><br>
              <input type="file" name="Certificate[]" class="form-control" multiple>
            <label>Nhập mô tả về gia sư</label><br>
            <textarea type="text" class="form-control" placeholder="Nhập mô tả về gia sư" name="description"></textarea>
              <label for="">Giới tính</label><br>
              Nam: <input type="radio" name="gender" id="" value="1">
              Nữ: <input type="radio" name="gender" id="" value="0"><br>
              <label for="" class="mt-2">Ngày sinh</label><br>
              <input type="date" class="form-control" name="date_of_birth">
            <label class="mt-2">Trạng thái</label><br>
            Kích hoạt: <input type="radio" name="status" id="" value="1">
            Chưa kích hoạt: <input type="radio" name="status" id="" value="0">
            @error('class')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-gray-800 mt-2 animate-up-2" type="submit">Thêm mới</button>
      </div>
    </form>
  </div>
</div>
@endsection
