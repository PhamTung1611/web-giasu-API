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
    <a href="{{ route('add_teacher') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
      <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
      </svg>
      Thêm mới giáo viên
    </a>
  </div>
</div>
<div class="table-settings mb-4">
  <div class="row align-items-center justify-content-between">
    <div class="col col-lg-8 col-xl-8 text-right">
      <form class="form-inline" action="{{ route('search_teacher') }}" method="POST">
        @csrf
    
        <div class="form-group mr-3">
            <label for="class_id" class="form-label">Môn học</label>
            <select name="class_id" id="" class="form-select form-select-sm">
                <option value="">Tất cả</option>
                @foreach($subject as $u)
                    <option value="{{$u->id}}">{{$u->name}}</option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group mr-3">
            <label for="subject_id" class="form-label">Lớp học</label>
            <select name="subject_id" id="" class="form-select form-select-sm">
                <option value="">Tất cả</option>
                @foreach($class as $u)
                    <option value="{{$u->ip}}">{{$u->class}}</option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group mr-3">
            <label for="District_ID" class="form-label">Khu vực dạy:</label> 
            <select name="District_ID" class="form-select form-select-sm">
                <option value="">Tất cả</option>
                <option value="Ba Đình">Ba Đình</option>
                <option value="Hoàn Kiếm">Hoàn Kiếm</option>
                <option value="Hai Bà Trưng">Hai Bà Trưng</option>
          <option value="Đống Đa">Đống Đa</option>
          <option value="Tây Hồ">Tây Hồ</option>
          <option value="Cầu Giấy">Cầu Giấy</option>
          <option value="Thanh Xuân">Thanh Xuân</option>
          <option value="Hoàng Mai">Hoàng Mai</option>
          <option value="Long Biên">Long Biên</option>
          <option value="Nam Từ Liêm">Nam Từ Liêm</option>
          <option value="Bắc Từ Liêm">Bắc Từ Liêm</option>
                <option value="Hà Đông">Hà Đông</option>
            </select>
        </div>
    
        <button type="submit" class="btn btn-secondary">Lọc</button>
    </form>
    
      {{-- <form class="input-group w-full h-10" action="{{route('search_teacher')}}" method="POST">
        @csrf
        <label for="class" class="form-label">Lớp Học</label>
        <select name="class" id="" class="form-select form-select-sm mb-3">
          <option value="">Tất cả</option>
          @foreach($subject as $u)
          <option value="{{$u->id}}">{{$u->name}}</option>
          @endforeach
        </select>
        <label for="class" class="form-label">Môn Học</label>
        <select name="subject" ip="" class="form-select form-select-sm mb-3">
          <option value="">Tất cả</option>
          @foreach($class as $u)
          <option value="{{$u->ip}}">{{$u->class}}</option>
          @endforeach
        </select>
        <label for="class" class="form-label">Khu vực dạy:</label> 
        <select name="District_ID" class="form-select form-select-sm mb-3">
          <option value="">Tất cả</option>
          <option value="Ba Đình">Ba Đình</option>
          <option value="Hoàn Kiếm">Hoàn Kiếm</option>
          
          <option value="Hà Đông">Hà Đông</option>
        </select>
        <button type="submit" class="btn btn-secondary mb-3">Lọc</button>
      </form> --}}
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
          <a class="dropdown-item d-flex align-items-center fw-bold" href="#">10 <svg class="icon icon-xxs ms-auto" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg></a>
          <a class="dropdown-item fw-bold" href="#">20</a>
          <a class="dropdown-item fw-bold rounded-bottom" href="#">30</a>
        </div>
      </div>
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
        <th>Khu vực dạy</th>
        <th>Trạng thái</th>
        <th>Người duyệt</th>
          <th>Ngày duyệt</th>
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
          <span class="fw-normal">{{$u->District_ID}}</span>
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
              <span class="fw-normal">{{$u->time_accept}}</span>
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
              @if($view!=2)
              <a class="dropdown-item ~text-gray-800 rounded-bottom" href="{{ route('detail_teacher', ['id' => $u->id])}}"><span class="fas fa-trash-alt me-2"></span>Chi tiết</a>
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
