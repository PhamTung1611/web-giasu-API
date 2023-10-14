@extends('template.layout')
@section('content')
<h1 class="text-center">{{$title}}</h1>
<form action="{{ route('job.add') }}" method="POST" enctype="multipart/form-data" style="width: 1200px" class="mx-auto mb-4">
  @csrf
  <div class="form-group">
    <label>Nhập tiêu đề</label><br>
    <input type="text" class="form-control" placeholder="Nhập tiêu đề..." name="title">
    @error('title')
    <span class="text-danger">{{$message}}</span>
    @enderror
  </div>
  <div class="form-group">
    <label>Nhập tên</label><br>
    <input type="text" class="form-control" placeholder="Nhập tên..." name="name">
    @error('name')
    <span class="text-danger">{{$message}}</span>
    @enderror
  </div>
  <div class="form-group">
    <label>Nhập địa chỉ</label><br>
    <input type="text" class="form-control" placeholder="Nhập địa chỉ..." name="address">
    @error('address')
    <span class="text-danger">{{$message}}</span>
    @enderror
  </div>
  <div class="form-group">
    <label>Nhập ngày dạy</label><br>
    <select class="form-select w-100 mb-0" id="state" name="date_time" aria-label="State select example">
      @foreach ($date as $item)
          <option value="{{ $item->id }}">{{ $item->value }}</option>
      @endforeach
  </select>
    @error('date_time')
    <span class="text-danger">{{$message}}</span>
    @enderror
  </div>
  <div class="form-group">
    <label>Nhập số điện thoại</label><br>
    <input type="text" class="form-control" placeholder="Nhập sdt..." name="phone">
    @error('phone')
    <span class="text-danger">{{$message}}</span>
    @enderror
  </div>
  
    <div class="form-group">
      <label>Nhập emmail</label><br>
      <input type="text" class="form-control" placeholder="Nhập email..." name="email">
      @error('email')
      <span class="text-danger">{{$message}}</span>
      @enderror
    </div>
    <div class="form-group">
      <label>Nhập môn học</label><br>
      <input type="text" class="form-control" placeholder="Nhập moon học..." name="subjects_need">
      @error('subjects_need')
      <span class="text-danger">{{$message}}</span>
      @enderror
    </div>
    <div class="form-group">
      <label>Nhập trình độ học vấn</label><br>
      <input type="text" class="form-control" placeholder="Nhập trình độ học vấn..." name="education_level">
      @error('education_level')
      <span class="text-danger">{{$message}}</span>
      @enderror
    </div>
    <div class="form-group">
      <label>Nhập lương</label><br>
      <select class="form-select w-100 mb-0" id="state" name="salary" aria-label="State select example">
        @foreach ($salary as $sl)
          <option value="{{ $sl->id }}">{{ $sl->value }}</option>
        @endforeach
        </select>
      @error('salary')
      <span class="text-danger">{{$message}}</span>
      @enderror
    </div>
    <div class="form-group">
      <label>Nhập yêu cầu</label><br>
      <input type="text" class="form-control" placeholder="Nhập yêu cầu..." name="requirements">
      @error('requirements')
      <span class="text-danger">{{$message}}</span>
      @enderror
    </div>
    <button type="submit">Thêm mới</button>
</form>
@endsection