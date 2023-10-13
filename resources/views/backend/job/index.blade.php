@extends('template.layout')
@section('content')
    @if(Session::has('suscess'))
    <p>
        {{Session::get('suscess')}}
    </p>
        
    @endif
    @if(Session::has('error'))
        {{Session::get('error')}}
    @endif
    <table border="1" class="table">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Name</th>
                <th>Adress</th>
                <th>DateTime</th>
                <th>Phone</th>
                <th>Email</th>
                <th>SubjectNeed</th>
                <th>EducationLevel</th>
                <th>Salary</th>
                <th>Requirement</th>
                <th>Action</th>
            </tr>
        </thead>
        @foreach($jobs as $item)
        <tbody>
            <tr>
                <td>{{$item->id}}</td>
            <td>{{$item->title}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->address}}</td>
            <td>{{$item->date_time}}</td>
            <td>{{$item->phone}}</td>
            <td>{{$item->email}}</td>
            <td>{{$item->subjects_need}}</td>
            <td>{{$item->education_level}}</td>
            <td>{{$item->salary}}</td>
            <td>{{$item->requirements}}</td>
                <td>
                    <button type="button" class="btn btn-success"><a href="{{ route('job.edit', ['id' => $item->id])}}" class="text-white">Edit</a></button> 
                    <button type="button" class="btn btn-danger"><a href="{{ route('job.delete', ['id' => $item->id])}}" onclick="return confirm('Are you sure you want to delete?');" class="text-white">Delete</a></button> 
                </td>
                
            </tr>
        </tbody>
        @endforeach
    </table>
    <button type="button" class="btn btn-success"><a class="nav-link text-white" href="{{ route('job.add') }}" >Add new<span class="sr-only">(current)</span></a></button>
@endsection
