@extends('template.layout')
@section('content')
<h1 class="text-center">{{$title}}</h1>
<form action="{{ route('edit_class', ['id' => $class_levels->id]) }}" method="POST" enctype="multipart/form-data" style="width: 1200px" class="mx-auto mb-4">
  @csrf
    <div class="form-group">
      <label>Cập nhật tên lớp</label><br>
      @error('class')
      <span class="text-danger">{{$message}}</span>
      @enderror
      <input type="text" class="form-control" placeholder="Nhập tên lớp" name="class" value="{{$class_levels->class}}">
    </div>
    <div class="form-group">
    <label>Cập nhật môn học</label><br>
    @error('subject')
    <span class="text-danger">{{$message}}</span>
    @enderror
    <select class="form-select w-100 mb-0" id="state" name="subject" aria-label="State select example">
      @foreach ($subjects as $subject)
          <option value="{{ $subject->name }}" {{($class_levels->subject === $subject->id) ? 'selected' : ''}}>{{ $subject->name }}</option>
      @endforeach
  </select>
    </div>
    <button type="submit" class="btn btn-success">Cập nhật</button>
</form>
@endsection