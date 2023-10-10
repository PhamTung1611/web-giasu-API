@extends('template.layout')
@section('content')
<h1 class="text-center">{{$title}}</h1>
<form action="{{ route('add_subject') }}" method="POST" enctype="multipart/form-data" style="width: 1200px" class="mx-auto mb-4">
  @csrf
    <div class="form-group">
      <label>Tên môn học</label><br>
      @error('name')
      <span class="text-danger">{{$message}}</span>
      @enderror
      <input type="text" class="form-control" placeholder="Nhập tên môn học" name="name">
    </div>
    <button type="submit">Thêm mới</button>
</form>
@endsection