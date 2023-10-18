@extends('template.layout')
@section('content')
    @if(Session::has('suscess'))
        {{Session::get('suscess')}}
    @endif
    @if(Session::has('error'))
        {{Session::get('error')}}
    @endif
    <table border="1" class="table">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>CLASS</th>
                <th>SUBJECTID</th>
                <th>ACTION</th>
            </tr>
        </thead>
        @foreach($class_levels as $class_level)
        <tbody>
            <tr>
                <td>{{$class_level->id}}</td>
                <td>{{$class_level->class}}</td>
                <td>{{$class_level->subject}}</td>
                <td>
                    <button type="button" class="btn btn-success"><a href="{{ route('edit_class', ['id' => $class_level->id])}}" class="text-white">Edit</a></button> 
                    <button type="button" class="btn btn-danger"><a href="{{route('delete_class',['id'=>$class_level->id])}}" onclick="return confirm('Are you sure you want to delete?');" class="text-white">Delete</a></button> 
                </td>
                
            </tr>
        </tbody>
        @endforeach
    </table>
    <button type="button" class="btn btn-success"><a class="nav-link text-white" href="{{ route('add_class') }}">Add new<span class="sr-only">(current)</span></a></button>
@endsection
