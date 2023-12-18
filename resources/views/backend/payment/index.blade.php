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
          <li class="breadcrumb-item"><a href="#">Bảng</a></li>
        </ol>
      </nav>
      <h2 class="h4">{{$title}}</h2>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
      {{-- <a href="" class="btn btn-sm btn-danger d-inline-flex align-items-center mx-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16"> <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/> </svg>
        Kho lưu trữ
      </a> --}}

    </div>
  </div>
  <div class="table-settings mb-4">
    <div class="row align-items-center justify-content-between">
      <div class="col col-md-6 col-lg-3 col-xl-4">
        <form class="input-group me-2 me-lg-3 fmxw-400" action="{{route('search_class')}}" method="POST">
          @csrf
          <input type="text" class="form-control" placeholder="Nhập..." name="search">
          <input type="submit" value="Lọc" class="btn btn-secondary">
        </form>
      </div>
    </div>
</div>
<div class="card card-body border-0 shadow table-wrapper table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Người dùng</th>
                <th>Số dư</th>
                <th>Ngân hàng</th>
                <th>Mã giao dịch</th>
                <th>Trạng thái</th>
                <th>Ngày nạp</th>
            </tr>
        </thead>
        <tbody>
        @foreach($params as $item)
            <tr>
                <td>
                    <a href="" class="fw-bold">{{$item->id}}</a>
                </td>
                <td>
                    <span class="fw-normal">{{$item->userName}}</span>
                </td>
                <td>
                    <span class="fw-normal">{{$item->coin}}</span>
                </td>
                <td>
                    <span class="fw-normal">{{$item->bank}}</span>
                </td>
                <td>
                    <span class="fw-normal">{{$item->code}}</span>
                </td>
                <td>
                    <span class="fw-normal">{{$item->status}}</span>
                </td>
                <td>
                    <span class="fw-normal">{{$item->created_at}}</span>
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

