@extends('template.layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
  <div class="d-block mb-4 mb-md-0">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
      <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
        <li class="breadcrumb-item">
          <a href="http://127.0.0.1:8000/">
            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
              </path>
            </svg>
          </a>
        </li>
      </ol>
    </nav>
    <h2 class="h4">{{$title}}</h2>
  </div>

</div>
<div class="table-settings mb-4">
  <div class="row align-items-center justify-content-between">
    <div class="col-4 col-md-2 col-xl-1 ps-md-0 text-end">

    </div>
  </div>
</div>
<div class="card card-body border-0 shadow table-wrapper table-responsive">
  @if ($errors->any())
  @foreach ($errors->all() as $error)
  <p style="color: red;">{{ $error }}</p>
  @endforeach
  @endif
  <table class="table table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Tên</th>
        <th>Địa chỉ email</th>
        <th>Ảnh đại diện</th>
        <th>Số điện thoại</th>
        <th>Địa chỉ</th>
        <th>Trạng thái</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($teachers as $u)
      <tr>
        <td>
          <a href="" class="fw-bold">{{ $loop->iteration }}</a>
        </td>
        <td>
          <span class="fw-normal">{{$u->name}}</span>
        </td>
        <td>
          <span class="fw-normal">{{$u->email}}</span>
        </td>
        <td>
          {{-- <img src="{{$u->avatar}}" style="width: 50px;" alt=""> --}}
          <img src="{{$u->avatar?''.Storage::url($u->avatar):''}}" alt="" style="width: 70px; height: auto;">
        </td>
        <td>
          <span class="fw-normal">{{$u->phone}}</span>
        </td>
        <td>
          <span class="fw-normal">{{$u->address}}</span>
        </td>
        <td>
         
          <span class="fw-normal" style="color:red;}}">Không đạt</span>
         
        </td>
        <td>
          <div class="btn-group">
            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="icon icon-sm">
                <span class="fas fa-ellipsis-h icon-dark"></span>
              </span>
              <span>
                Thao tác
              </span>
            </button>
            <div class="dropdown-menu py-0">
            
{{--              <form action="{{ route('waiting_teacher',['id'=>$u->id])}}" method="get">--}}
{{--                @csrf--}}
{{--                <input type="hidden" value="{{$u->id}}" name="id">--}}
{{--                <button class="dropdown-item text-success rounded-bottom">Phê duyệt</button>--}}
{{--              </form>--}}
{{--              <a class="dropdown-item text-danger rounded-bottom" href="{{ route('delete_teacher', ['id' => $u->id,'view'=>'2'])}}" onclick="return confirm('Are you sure you want to refuse?');"><span class="fas fa-trash-alt me-2"></span>Từ chối</a>--}}
              <a class="dropdown-item ~text-gray-800 rounded-bottom" href="{{ route('deatailWaitingTeacher', ['id' => $u->id])}}"><span class="fas fa-trash-alt me-2"></span>Xem chi tiết</a>
             
            </div>
          </div>
        </td>

      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">

    <div class="alert alert-success" role="alert">
      @if(Session::has('success'))
      {{Session::get('success')}}
      @endif
      @if(Session::has('error'))
      {{Session::get('error')}}
      @endif
    </div>
  </div>
</div>
@endsection
