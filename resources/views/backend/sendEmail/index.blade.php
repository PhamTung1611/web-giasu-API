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
  </div>
</div>
<div class="table-settings mb-4">
  <div class="row align-items-center justify-content-between">
    <div class="col-md-10 col-lg-3 col-xl-4">
      <form class="d-flex align-items-end" action="{{ route('sendMail') }}" method="POST">
        @csrf
        <div class="form-group mr-2 mb-0">
          <label for="dateStart" class="form-label">Ngày bắt đầu</label>
          <input type="date" name="dateStart" class="form-control" id="dateStart">
        </div>

        <div class="form-group mr-2 mb-0">
          <label for="dateEnd" class="form-label">Ngày kết thúc</label>
          <input type="date" name="dateEnd" class="form-control" id="dateEnd">
        </div>

        <div class="form-group mb-0">
          <button type="submit" class="btn btn-secondary btn-sm align-self-end">Lọc</button>
        </div>
      </form>
    </div>
    <div class="col-md-2 col-xl-1 ps-md-0 text-end">
          <div class="dropdown">
              <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="visually-hidden">Toggle Dropdown</span>
              </button>
              <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end pb-0">
                  <span class="small ps-3 fw-bold text-dark">Show</span>
                  <a class="dropdown-item d-flex align-items-center fw-bold" href="http://127.0.0.1:8000/sendMail">Tất cả</a>
                  <a class="dropdown-item fw-bold" href="{{ route('search_mail',1) }}">Mail thuê</a>
                  <a class="dropdown-item fw-bold" href="{{ route('search_mail',2) }}">Mail nhận yêu cầu thuê</a>
                  <a class="dropdown-item fw-bold" href="{{ route('search_mail',3) }}">Mail đồng ý dạy</a>
                  <a class="dropdown-item fw-bold" href="{{ route('search_mail',4) }}">Mail từ chối dạy</a>
                  <a class="dropdown-item fw-bold" href="{{ route('search_mail',5) }}">Mail xác nhận kết nối</a>
                  <a class="dropdown-item fw-bold" href="{{ route('search_mail',6) }}">Mail từ chối kết nối</a>
                  <a class="dropdown-item fw-bold" href="{{ route('search_mail',7) }}">Mail đăng ký</a>
                  <a class="dropdown-item fw-bold" href="{{ route('search_mail',8) }}">Mail đổi mật khẩu</a>
                  <a class="dropdown-item fw-bold" href="{{ route('search_mail',9) }}">Mail phê duyệt gia sư</a>
                  <a class="dropdown-item fw-bold" href="{{ route('search_mail',10) }}">Mail phê duyệt chứng chỉ</a>
                  <a class="dropdown-item fw-bold" href="{{ route('search_mail',11) }}">Mail từ chối gia sư</a>
                  <a class="dropdown-item fw-bold" href="{{ route('search_mail',12) }}">Mail từ chối chứng chỉ</a>
              </div>
          </div>
      </div>
  </div>
</div>
<div class="card card-body border-0 shadow table-wrapper table-responsive">
  <table border="1" class="table table-hover">
    <thead>
      <tr>
        <th>Tên người nhận</th>
        <th>Email nhận</th>
        <th>Kiểu</th>
        <th>Nội dung</th>
        <th>Ngày gửi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data as $item)
      <tr>
        <td>
          <a href="" class="fw-bold"><a href="{{ route('detail_teacher', ['id' => $item->id_user])}}">{{$item->name}}</a>
        </td>

        <td>
          <span class="fw-normal">{{$item->email}}</span>
        </td>
        <td>
          <span class="fw-normal">{{$item->type}}</span>
        </td>
        <td>
          <span class="fw-normal">{{$item->content}}</span>
        </td>
        <td>
          <span class="fw-normal">{{$item->created_at}}</span>
        </td>

      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">

  </div>
</div>
@endsection