@extends('template.layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
  <div class="d-block mb-4 mb-md-0">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
      <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
        <li class="breadcrumb-item">
          <a href="#">
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
  <div class="btn-toolbar mb-2 mb-md-0">
    <a href="{{ route('add_ctv') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
      <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
      </svg>
      Thêm mới cộng tác viên
    </a>
  </div>
</div>
<div class="table-settings mb-4">
  <div class="row align-items-center justify-content-between">
    <div class="col col-md-6 col-lg-3 col-xl-4">
      <form class="input-group me-2 me-lg-3 fmxw-400" action="{{route('allctv')}}" method="POST">
        @csrf
        <input type="text" class="form-control" placeholder="Tìm kiếm..." name="search">
        <input type="submit" value="Lọc" class="btn btn-secondary">
      </form>
    </div>
    <div class="col-4 col-md-2 col-xl-1 ps-md-0 text-end">
      <div class="dropdown">
        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
          </svg>
          <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end pb-0">
          <span class="small ps-3 fw-bold text-dark">Show</span>
          <a class="dropdown-item d-flex align-items-center fw-bold" href="{{route('allctv')}}">Tất cả</a>

          <a class="dropdown-item fw-bold" href="{{ route('ctv_by_status', ['status' => 1]) }}">Hoạt động</a>
          <a class="dropdown-item fw-bold rounded-bottom" href="{{ route('ctv_by_status', ['status' => 2]) }}">Không hoạt động</a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card card-body border-0 shadow table-wrapper table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Tên</th>
        <th>Email</th>
        <th>Ảnh đại diện</th>
        <th>Số điện thoại</th>
        <th>Địa chỉ</th>
        <th>Trạng thái</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $u)
      <tr>
        <td>
          <a href="" class="fw-bold">{{$u->id}}</a>
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
        <span class="fw-normal" style="color: {{ $u->status == 1 ? 'green' : 'red' }}">{{$u->status == "1" ? 'Hoạt động' : 'Không hoạt động' }}</span>
        </td>
        <td>
          <div class="btn-group">
            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="icon icon-sm">
                <span class="fas fa-ellipsis-h icon-dark"></span>
              </span>
              <span>
                Xem chi tiết
              </span>
            </button>
            <div class="dropdown-menu py-0">
              @if ($u->status == 1)
                  <a href="{{ route('deactivate_ctv', ['id' => $u->id]) }}" class="btn btn-link text-warning" onclick="return confirm('Are you sure you want to deactivate?');">
                      <span class="fas fa-toggle-off me-2"></span>Tắt kích hoạt
                  </a>
              @else
                  <a href="{{ route('activate_ctv', ['id' => $u->id]) }}" class="btn btn-link text-success" onclick="return confirm('Are you sure you want to activate?');">
                      <span class="fas fa-toggle-on me-2"></span>Kích hoạt
                  </a>
              @endif
              <a class="dropdown-item" href="{{ route('edit_ctv', ['id' => $u->id])}}"><span class="fas fa-edit me-2"></span>Edit</a>
              <a class="dropdown-item text-danger rounded-bottom" href="{{ route('delete_ctv', ['id' => $u->id])}}" onclick="return confirm('Are you sure you want to delete?');"><span class="fas fa-trash-alt me-2"></span>Remove</a>
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
