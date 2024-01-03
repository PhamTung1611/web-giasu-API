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
          {{-- <li class="breadcrumb-item"><a href="#">Bảng</a></li> --}}
        </ol>
      </nav>
      <h2 class="h4">{{$title}}</h2>
    </div>
    
  </div>
  <div class="table-settings mb-4">
    <div class="row align-items-center justify-content-between">
      <div class="col col-md-6 col-lg-3 col-xl-4">
        <form class="input-group me-2 me-lg-3 fmxw-400" action="{{route('allcertificate')}}" method="GET">
          @csrf
          <input type="text" class="form-control" placeholder="Nhập..." name="email">
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
                <th>Email</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
        @foreach($user as $u)
            <tr>
                <td>
                    <a href="" class="fw-bold">{{$u->id}}</a>
                </td>
                <td>
                    <span class="fw-normal">{{$u->email}}</span>
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
                        <a class="dropdown-item" href="{{ route('show-certificate', ['id' => $u->id])}}"><span class="fas fa-edit me-2"></span>show</a>
                        </div>
                    </div>
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

