@extends('template.layout')
@section('content')
<h1 class="text-center">{{$title}}</h1>
<form action="{{ route('salary.edit', ['id' => $salary->id]) }}" method="POST" enctype="multipart/form-data" style="width: 1200px" class="mx-auto mb-4">
  @csrf
    <div class="form-group">
      <label>Lươnng</label><br>
      @error('value')
      <span class="text-danger">{{$message}}</span>
      @enderror
      <input type="text" class="form-control" name="value" value="{{$salary->value}}">
    </div>
    <button type="submit" class="btn btn-success">Cập nhật</button>
</form>
@endsection