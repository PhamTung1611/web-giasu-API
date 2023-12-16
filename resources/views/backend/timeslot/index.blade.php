@extends('template.layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
      <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
          <li class="breadcrumb-item">
            <a href="#">
              <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
              </svg>
            </a>
          </li>
        </ol>
      </nav>
      <h2 class="h4">{{$title}}</h2>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
      <a href="{{route('timeslot.add')}}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
        <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Thêm mới ca học
      </a>
    </div>
  </div>
  <div class="table-settings mb-4">
    <div class="row align-items-center justify-content-between">
      <div class="col col-md-6 col-lg-3 col-xl-4">
        <form class="input-group me-2 me-lg-3 fmxw-400" action="{{route('search_timeslot')}}" method="POST">
          @csrf
          <input type="text" class="form-control" placeholder="Tìm kiếm..." name="search">
          <input type="submit" value="Lọc" class="btn btn-secondary">
        </form>
      </div>
      <div class="col-4 col-md-2 col-xl-1 ps-md-0 text-end">
      </div>
    </div>
</div>
<div class="card card-body border-0 shadow table-wrapper table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <!-- Item -->
        @foreach($timeslots as $item)
            <tr>
                <td>
                    <a href="" class="fw-bold">{{$item->id}}</a>
                </td>
                <td>
                    <span class="fw-normal">{{$item->name}}</span>
                </td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon icon-sm">
                            <span class="fas fa-ellipsis-h icon-dark"></span>
                        </span>
                        <span>
                          Thao tác
                        </span>
                        </button>
                        <div class="dropdown-menu py-0">
                        
                        <a class="dropdown-item" href="{{ route('timeslot.teachers', ['id' => $item->id])}}"><span class="fas fa-edit me-2"></span>Danh sách giáo viên</a>
                        <a class="dropdown-item" href="{{ route('timeslot.edit', ['id' => $item->id])}}"><span class="fas fa-edit me-2"></span>Sửa</a>
                        <a class="dropdown-item text-danger rounded-bottom" href="{{ route('timeslot.delete', ['id' => $item->id])}}" onclick="return confirm('Are you sure you want to delete?');"><span
                            class="fas fa-trash-alt me-2"></span>Xóa</a>
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
