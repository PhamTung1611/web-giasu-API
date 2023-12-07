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
        <th>Assign</th>
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
          @if($view!=2)
          <span class="fw-normal" style="color: {{ $u->status == 1 ? 'green' : 'red' }}">{{$u->status == "1" ? 'Hoạt động' : 'Không hoạt động' }}</span>
          @else
          <span class="fw-normal">wating</span>
          @endif
        </td>
        <td>
          <span class="fw-normal">{{$u->assign_user}}</span>
        </td>
        <td>
          <div class="btn-group">
            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="icon icon-sm">
                <span class="fas fa-ellipsis-h icon-dark"></span>
              </span>
              <span>
                Views
              </span>
            </button>
            <div class="dropdown-menu py-0">
              @if($view!=2)
              <a class="dropdown-item ~text-gray-800 rounded-bottom" href="{{ route('detail_teacher', ['id' => $u->id])}}"><span class="fas fa-trash-alt me-2"></span>show</a>
              <a class="dropdown-item" href="{{ route('edit_teacher', ['id' => $u->id])}}"><span class="fas fa-edit me-2"></span>Sửa</a>
              <a class="dropdown-item text-danger rounded-bottom" href="{{ route('delete_teacher', ['id' => $u->id,'view'=>'1'])}}" onclick="return confirm('Are you sure you want to delete?');"><span class="fas fa-trash-alt me-2"></span>Xóa</a>
              @else
              <form action="{{ route('waiting_teacher')}}" method="post">
                @csrf
                <input type="hidden" value="{{$u->id}}" name="id">
                <button class="dropdown-item text-success rounded-bottom">Phê duyệt</button>
              </form>
              <a class="dropdown-item text-danger rounded-bottom" href="{{ route('delete_teacher', ['id' => $u->id,'view'=>'2'])}}" onclick="return confirm('Are you sure you want to refuse?');"><span class="fas fa-trash-alt me-2"></span>Từ chối</a>
              <a class="dropdown-item ~text-gray-800 rounded-bottom" href="{{ route('deatailWaitingTeacher', ['id' => $u->id])}}"><span class="fas fa-trash-alt me-2"></span>show</a>
              @endif
            </div>
          </div>
        </td>

      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
    <nav aria-label="Page navigation example">
      <ul class="pagination mb-0">
        <li class="page-item">
          <a class="page-link" href="#">Previous</a>
        </li>
        <li class="page-item active">
          <a class="page-link" href="#">1</a>
        </li>
        <li class="page-item ">
          <a class="page-link" href="#">2</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">3</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">4</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">5</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">Next</a>
        </li>
      </ul>
    </nav>
    <div class="alert alert-success" role="alert">
      @if(Session::has('success'))
      {{Session::get('success')}}
      @endif
      @if(Session::has('error'))
      {{Session::get('error')}}
      @endif
    </div>
    <div class="fw-normal small mt-4 mt-lg-0">Showing <b>5</b> out of <b>25</b> entries</div>
  </div>
</div>
@endsection