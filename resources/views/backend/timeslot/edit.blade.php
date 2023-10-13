@extends('template.layout')
@section('content')
<h1 class="text-center">{{$title}}</h1>
<form action="{{ route('timeslot.edit', ['id' => $timeslot->id]) }}" method="POST" enctype="multipart/form-data" style="width: 1200px" class="mx-auto mb-4">
  @csrf
    <div class="form-group">
      <label>Thời gian dạy</label><br>
      @error('value')
      <span class="text-danger">{{$message}}</span>
      @enderror
      <input type="text" class="form-control" name="value" value="{{$timeslot->value}}">
    </div>
    <button type="submit" class="btn btn-success">Cập nhật</button>
</form>
@endsection