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
                <th>Value</th>
                <th>Action</th>
            </tr>
        </thead>
        @foreach($timeslots as $item)
        <tbody>
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->value}}</td>
                <td>
                    <button type="button" class="btn btn-success"><a href="{{ route('timeslot.edit', ['id' => $item->id])}}" class="text-white">Edit</a></button> 
                    <button type="button" class="btn btn-danger"><a href="{{ route('timeslot.delete', ['id' => $item->id])}}" onclick="return confirm('Are you sure you want to delete?');" class="text-white">Delete</a></button> 
                </td>
                
            </tr>
        </tbody>
        @endforeach
    </table>
    <button type="button" class="btn btn-success"><a class="nav-link text-white" href="{{route('timeslot.add')}}" >Add new<span class="sr-only">(current)</span></a></button>
@endsection
