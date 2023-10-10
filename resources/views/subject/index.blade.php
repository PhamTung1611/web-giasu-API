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
                <th>NAME</th>
                <th>ACTION</th>
            </tr>
        </thead>
        @foreach($subject as $subjects)
        <tbody>
            <tr>
                <td>{{$subjects->id}}</td>
                <td>{{$subjects->name}}</td>
                <td>
                    <button type="button" class="btn btn-success"><a href="{{ route('edit_subject', ['id' => $subjects->id])}}" class="text-white">Edit</a></button> 
                    <button type="button" class="btn btn-danger"><a href="{{ route('delete_subject',['id'=>$subjects->id])}}" onclick="return confirm('Are you sure you want to delete?');" class="text-white">Delete</a></button> 
                </td>
                
            </tr>
        </tbody>
        @endforeach
    </table>
    <button type="button" class="btn btn-success"><a class="nav-link text-white" href="{{ route('add_subject') }}" >Add new<span class="sr-only">(current)</span></a></button>
@endsection
