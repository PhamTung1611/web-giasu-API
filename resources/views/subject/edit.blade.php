@extends('template.layout')
@section('content')
<h1 class="text-center">{{$title}}</h1>
<form action="{{ route('edit_subject', ['id' => $subject->id]) }}" method="POST" enctype="multipart/form-data" style="width: 1200px" class="mx-auto mb-4">
  @csrf
    <div class="form-group">
      <label>Cập nhật tên môn học</label><br>
      @error('name')
      <span class="text-danger">{{$message}}</span>
      @enderror
      <input type="text" class="form-control" placeholder="Nhập tên môn học" name="name" value="{{$subject->name}}">
    </div>
    <button type="submit" class="btn btn-success">Cập nhật</button>
</form>
@endsection