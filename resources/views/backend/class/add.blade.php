@extends('template.layout')
@section('content')
<h1 class="text-center">{{$title}}</h1>
<form action="{{ route('add_class') }}" method="POST" enctype="multipart/form-data" style="width: 1200px" class="mx-auto mb-4">
  @csrf
    <div class="form-group">
      <label>Tên lớp</label><br>
      @error('class')
      <span class="text-danger">{{$message}}</span>
      @enderror
      <input type="text" class="form-control" placeholder="Nhập tên lớp" name="class">
    </div>
    <div class="form-group">
    <label>Chọn môn học</label><br>
    @error('subject')
    <span class="text-danger">{{$message}}</span>
    @enderror
    <select class="form-select w-100 mb-0" id="state" name="subject" aria-label="State select example">
        @foreach ($subject as $subjects)
            <option value="{{ $subjects->name }}">{{ $subjects->name }}</option>
        @endforeach
    </select>
    </div>
    <button type="submit">Them moi</button>
</form>
@endsection