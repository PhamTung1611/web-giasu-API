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
        <th>Mô tả</th>
        <th>Ngày gửi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($result as $item)
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