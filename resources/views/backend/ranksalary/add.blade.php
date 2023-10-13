@extends('template.layout')
@section('content')
<h1 class="text-center">{{$title}}</h1>
<form action="{{ route('salary.add') }}" method="POST" enctype="multipart/form-data" style="width: 1200px" class="mx-auto mb-4">
  @csrf
    <div class="form-group">
      <label>Nhập giá trị</label><br>
      <input type="text" class="form-control" placeholder="Nhập giá trị..." name="value">
      @error('value')
      <span class="text-danger">{{$message}}</span>
      @enderror
    </div>
    <button type="submit">Thêm mới</button>
</form>
@endsection